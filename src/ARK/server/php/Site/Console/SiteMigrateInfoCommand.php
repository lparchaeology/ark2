<?php

/**
 * ARK Console Command.
 *
 * Copyright (C) 2017  L - P : Heritage LLP.
 *
 * This file is part of ARK, the Archaeological Recording Kit.
 *
 * ARK is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ARK is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ARK.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     John Layt <j.layt@lparchaeology.com>
 * @copyright  2017 L - P : Heritage LLP.
 * @license    GPL-3.0+
 *
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\Site\Console;

use ARK\ARK;
use ARK\Console\ProcessTrait;
use ARK\Database\Console\DatabaseCommand;
use Symfony\Component\Console\Helper\Table;

class SiteMigrateInfoCommand extends DatabaseCommand
{
    use ProcessTrait;

    protected $source = null;
    protected $modules = [];
    protected $itemkeys = [];
    protected $sites = [];
    protected $types = [];
    protected $tables = [];
    protected $frags = [];

    protected function configure()
    {
        $this->setName('site:migrate:info')
             ->setDescription('Information on an ARK 1 site');
    }

    protected function doExecute()
    {
        $sourceConfig = $this->chooseDatabaseConfig();
        if (!is_array($sourceConfig)) {
            return $this->errorCode();
        }
        $this->source = $this->getConnection($sourceConfig);
        $this->source->beginTransaction();

        // SITES
        $this->write("\nSITES");
        $this->sites = $this->source->fetchAllTable('cor_tbl_ste');
        $table = new Table($this->output);
        $table->setHeaders(['ID', 'Description']);
        foreach ($this->sites as $site) {
            $table->addRow([$site['id'], $site['description']]);
        }
        $table->render();
        $this->write('');

        // MODULES
        $this->modules = $this->source->fetchAllTable('cor_tbl_module');
        $this->write("\nMODULES");
        $table = new Table($this->output);
        $table->setHeaders(['Code', 'Description', 'Modtype', 'Table', 'Rows']);
        foreach ($this->modules as &$module) {
            $mod = $module['shortform'];
            if ($mod == 'cor') {
                continue;
            }
            $this->itemkeys[] = $module['itemkey'];
            $module['table'] = $mod.'_tbl_'.$mod;
            $module['rows'] = $this->source->countRows($module['table']);
            $module['modtype'] = $mod.'type';
            $module['lut'] = $mod.'_lut_'.$module['modtype'];
            $module['modtypes'] = [];
            if ($this->source->tableExists($module['lut'])) {
                $modtypes = $this->source->fetchAllTable($module['lut']);
                foreach ($modtypes as $modtype) {
                    if (isset($modtype[$module['modtype']])) {
                        $module['modtypes'][] = strtolower($modtype[$module['modtype']]);
                    }
                }
            } else {
                $module['modtype'] = null;
                $module['lut'] = null;
                $module['modtypes'] = [];
            }
            $table->addRow([$module['shortform'], $module['description'], $module['modtype'], $module['table'], $module['rows']]);
        }
        $table->render();
        $this->write('');

        // ACTIONS
        $this->buildTypes('action');
        $sql = '
            SELECT cor_tbl_action.*, cor_lut_actiontype.actiontype
            FROM cor_tbl_action, cor_lut_actiontype
            WHERE cor_tbl_action.actiontype = cor_lut_actiontype.id
        ';
        $this->countFrags('action', $sql);

        // ATTRIBUTES
        $this->buildTypes('attribute');
        $sql = '
            SELECT cor_tbl_attribute.*, cor_lut_attribute.attribute, cor_lut_attributetype.attributetype
            FROM cor_tbl_attribute, cor_lut_attribute, cor_lut_attributetype
            WHERE cor_tbl_attribute.attribute = cor_lut_attribute.id
            AND cor_lut_attribute.attributetype = cor_lut_attributetype.id
        ';
        $this->countFrags('attribute', $sql);

        // FILES
        $this->buildTypes('file');
        $sql = '
            SELECT cor_tbl_file.*, cor_lut_filetype.filetype
            FROM cor_tbl_file, cor_lut_file, cor_lut_filetype
            WHERE cor_tbl_file.file = cor_lut_file.id
            AND cor_lut_file.filetype = cor_lut_filetype.id
        ';
        $this->countFrags('file', $sql);

        // DATE
        $this->buildTypes('date');
        $this->countTypeFrags('date');

        // NUMBER
        $this->buildTypes('number');
        $this->countTypeFrags('number');

        // TEXT
        $this->buildTypes('txt');
        $this->countTypeFrags('txt');

        // SPAN
        $this->buildTypes('span');
        $this->countTypeFrags('span');

        // * COPY XMIS * //
        $frags = $this->source->fetchAllTable('cor_tbl_xmi');
        foreach ($frags as $frag) {
            $mod = $frag['itemkey'];
            $xmi = $frag['xmi_itemkey'];
            if (isset($this->frags[$mod]['xmi'][$xmi])) {
                $this->frags[$mod]['xmi'][$xmi] += 1;
            } else {
                $this->frags[$mod]['xmi'][$xmi] = 1;
            }
            if (isset($this->frags[$xmi]['xmi'][$mod])) {
                $this->frags[$xmi]['xmi'][$mod] += 1;
            } else {
                $this->frags[$xmi]['xmi'][$mod] = 1;
            }
        }

        // MODULE SCHEMA
        foreach ($this->modules as &$module) {
            if ($module['shortform'] == 'cor' || !isset($this->frags[$module['itemkey']])) {
                continue;
            }
            $module['frags'] = $this->frags[$module['itemkey']];
            $this->write("\n".$module['shortform']);
            $table = new Table($this->output);
            $table->setHeaders(['Class', 'Field', 'Count']);
            foreach ($module['frags'] as $class => $fields) {
                foreach ($fields as $field => $count) {
                    $table->addRow([$class, $field, $count]);
                }
            }
            $table->render();
            $this->write('');
        }

        // TYPES
        $this->write("\nThe following attribute types exist:");
        $this->types = $this->source->fetchAllTable('cor_lut_attributetype');
        foreach ($this->types as $type) {
            $sql = '
                SELECT cor_lut_attribute.*, cor_lut_attributetype.attributetype
                FROM cor_lut_attribute, cor_lut_attributetype
                WHERE cor_lut_attribute.attributetype = ?
                AND cor_lut_attribute.attributetype = cor_lut_attributetype.id
            ';
            $this->types['values'] = $this->source->fetchAll($sql, [$type['id']]);
            $this->write("\n  ".$type['attributetype'].' ['.$type['module'].'] ('.count($this->types['values']).')');
            foreach ($this->types['values'] as $value) {
                $this->write('    '.$value['attribute']);
            }
        }
        $this->write('');
    }

    private function getItemkey($frag)
    {
        if (!isset($frag['itemkey'])) {
            return 'error';
        }
        if (in_array($frag['itemkey'], $this->itemkeys)) {
            return $frag['itemkey'];
        }
        if (!in_array($frag['itemkey'], $this->tables) && $this->source->tableExists($frag['itemkey'])) {
            $this->tables[] = $frag['itemkey'];
        }
        if (in_array($frag['itemkey'], $this->tables)) {
            $tbl = $frag['itemkey'];
            $sql = "
                SELECT *
                FROM $tbl
                WHERE id = ?
            ";
            $parent = $this->source->fetchAssoc($sql, [$frag['itemvalue']]);

            return $this->getItemkey($parent);
        }

        return $frag['itemkey'];
    }

    private function countTypeFrags($type)
    {
        $typename = $type.'type';
        $sql = "
            SELECT cor_tbl_$type.*, cor_lut_$typename.$typename
            FROM cor_tbl_$type, cor_lut_$typename
            WHERE cor_tbl_$type.$typename = cor_lut_$typename.id
        ";
        $this->countFrags($type, $sql);
    }

    private function countFrags($type, $sql)
    {
        $frags = $this->source->fetchAll($sql);
        $typename = $type.'type';
        foreach ($frags as $frag) {
            $modcode = $this->getItemkey($frag);
            $field = $frag[$typename];
            if (isset($this->frags[$modcode][$type][$field])) {
                $this->frags[$modcode][$type][$field] += 1;
            } else {
                $this->frags[$modcode][$type][$field] = 1;
            }
        }
    }

    private function buildTypes($type)
    {
        $typename = $type.'type';
        $types = $this->source->fetchAllTable('cor_lut_'.$typename);
        foreach ($types as $type) {
            $modcode = $type['module'];
            $field = $frag[$typename];
            $this->types[$modcode][$type][$field] = null;
        }
    }
}
