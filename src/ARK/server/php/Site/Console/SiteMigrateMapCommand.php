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
 * @license    GPL-3.0+.
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Site\Console;

use ARK\ARK;
use ARK\Console\ProcessTrait;
use ARK\Database\Console\DatabaseCommand;
use Symfony\Component\Console\Helper\Table;

class SiteMigrateMapCommand extends DatabaseCommand
{
    use ProcessTrait;

    protected $source = null;
    protected $exportPath = null;
    protected $modules = [];
    protected $itemkeys = [];
    protected $sites = [];
    protected $users = [];
    protected $actors = [];
    protected $types = [];
    protected $tables = [];
    protected $frags = [];

    protected function configure()
    {
        $this->setName('site:migrate:map')
             ->setDescription('Migration mapping for an ARK 1 site');
    }

    protected function doExecute()
    {
        $sourceConfig = $this->chooseDatabaseConfig();
        if (!is_array($sourceConfig)) {
            return $this->errorCode();
        }
        $this->source = $this->getConnection($sourceConfig);
        $this->source->beginTransaction();

        if ($this->askConfirmation('Do you want to save the mapping?', false)) {
            $this->exportPath = ARK::varDir().'/migrate/'.$this->source->getDatabase();
            $this->write("The mapping will be written to ".$this->exportPath);
        }

        // SITES
        $this->write("Analysing Sites...");
        $sites = $this->source->fetchAllTable('cor_tbl_ste');
        foreach ($sites as $site) {
            $site['modules'] = [];
            $site['items'] = 0;
            $this->sites[$site['id']] = $site;
        }

        // MODULES
        $this->write("Analysing Modules...");
        $this->modules = $this->source->fetchAllTable('cor_tbl_module');
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
            foreach (array_keys($this->sites) as $id) {
                $count = $this->countItems($module['table'], $id);
                $this->sites[$id]['modules'][$mod] = $count;
                $this->sites[$id]['items'] += $count;
            }
        }
        unset($module);

        // USERS
        $this->write("Analysing Users...");
        $sql = '
            SELECT cor_tbl_users.*, abk_tbl_abk.ste_cd, abk_lut_abktype.abktype
            FROM cor_tbl_users
            LEFT JOIN abk_tbl_abk
            ON cor_tbl_users.itemvalue = abk_tbl_abk.abk_cd
            LEFT JOIN abk_lut_abktype
            ON abk_tbl_abk.abktype = abk_lut_abktype.abktype
        ';
        $users = $this->source->fetchAll($sql);
        foreach ($users as $row) {
            $user['user'] = $row['id'];
            $user['username'] = $row['username'];
            $user['actor'] = $row['itemvalue'];
            $user['name'] = $row['firstname'].' '.$row['lastname'];
            $user['type'] = null;
            $user['site'] = $row['ste_cd'];
            $user['audit'] = false;
            $user['action'] = false;
            $user['roles'] = [];
            $this->users[$user['user']] = $user;
        }
        $sql = '
            SELECT cor_tbl_users.id, cor_lvu_groups.group_define_name
            FROM cor_tbl_users, cor_lvu_perm_users, cor_lvu_groupusers, cor_lvu_groups
            WHERE cor_tbl_users.id = cor_lvu_perm_users.auth_user_id
            AND cor_lvu_perm_users.perm_user_id = cor_lvu_groupusers.perm_user_id
            AND cor_lvu_groupusers.group_id = cor_lvu_groups.group_id
        ';
        $usergroups = $this->source->fetchAll($sql);
        foreach ($usergroups as $user) {
            $this->users[$user['id']]['roles'][] = $user['group_define_name'];
        }

        // ACTORS
        $this->write("Analysing Actors...");
        $sql = '
            SELECT *
            FROM cor_lut_txttype
            WHERE cor_lut_txttype.txttype = ?
        ';
        $txttype = $this->source->fetchAssoc($sql, ['name']);
        $sql = '
            SELECT abk_tbl_abk.*, abk_lut_abktype.abktype, cor_tbl_txt.txt
            FROM abk_tbl_abk
            LEFT JOIN abk_lut_abktype
            ON abk_tbl_abk.abktype = abk_lut_abktype.id
            LEFT JOIN cor_tbl_txt
            ON cor_tbl_txt.itemkey = ?
            AND cor_tbl_txt.itemvalue = abk_tbl_abk.abk_cd
            AND cor_tbl_txt.txttype = ?
        ';
        $actors = $this->source->fetchAll($sql, ['abk_cd', $txttype['id']]);
        foreach ($actors as $row) {
            $actor['actor'] = $row['abk_cd'];
            $actor['username'] = null;
            $actor['name'] = $row['txt'];
            $actor['site'] = $row['ste_cd'];
            $actor['type'] = $row['abktype'];
            $actor['action'] = false;
            $this->actors[$row['abk_cd']] = $actor;
        }

        // ACTIONS
        $this->write("Analysing Actions...");
        $this->buildTypes('action');
        $sql = '
            SELECT cor_tbl_action.*, cor_lut_actiontype.actiontype
            FROM cor_tbl_action, cor_lut_actiontype
            WHERE cor_tbl_action.actiontype = cor_lut_actiontype.id
        ';
        $this->summariseFrags('action', $sql);

        // ATTRIBUTES
        $this->write("Analysing Attributes...");
        $sql = '
            SELECT cor_lut_attribute.*, cor_lut_attributetype.attributetype, cor_lut_attributetype.module
            FROM cor_lut_attribute, cor_lut_attributetype
            WHERE cor_lut_attribute.attributetype = cor_lut_attributetype.id
        ';
        $this->buildTypes('attribute', $sql);
        $sql = '
            SELECT cor_tbl_attribute.*, cor_lut_attribute.attribute, cor_lut_attributetype.attributetype
            FROM cor_tbl_attribute, cor_lut_attribute, cor_lut_attributetype
            WHERE cor_tbl_attribute.attribute = cor_lut_attribute.id
            AND cor_lut_attribute.attributetype = cor_lut_attributetype.id
        ';
        $this->summariseFrags('attribute', $sql);

        // FILES
        $this->write("Analysing Files...");
        $this->buildTypes('file');
        $sql = '
            SELECT cor_tbl_file.*, cor_lut_filetype.filetype
            FROM cor_tbl_file, cor_lut_file, cor_lut_filetype
            WHERE cor_tbl_file.file = cor_lut_file.id
            AND cor_lut_file.filetype = cor_lut_filetype.id
        ';
        $this->summariseFrags('file', $sql);

        // DATE
        $this->write("Analysing Date Fragments...");
        $this->buildTypes('date');
        $this->summariseTypeFrags('date');

        // NUMBER
        $this->write("Analysing Number Fragments...");
        $this->buildTypes('number');
        $this->summariseTypeFrags('number');

        // TEXT
        $this->write("Analysing Text Fragments...");
        $this->buildTypes('txt');
        $this->summariseTypeFrags('txt');

        // SPAN
        $this->write("Analysing Spans...");
        $this->buildTypes('span');
        $this->summariseTypeFrags('span');

        // XMI
        $this->write("Analysing XMIs...");
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
            if ($mod == 'abk_cd') {
                $this->actors[$frag['itemvalue']]['action'] = true;
            }
            if ($xmi == 'abk_cd') {
                $this->actors[$frag['xmi_itemvalue']]['action'] = true;
            }
        }

        // USERS / ACTORS
        foreach ($this->users as $id => &$user) {
            if (isset($user['actor']) && isset($this->actors[$user['actor']])) {
                $user['action'] = $this->actors[$user['actor']]['action'];
                $user['type'] = $this->actors[$user['actor']]['type'] ?? null;
                unset($this->actors[$user['actor']]);
            }
            if (!isset($user['user'])) {
                $user['user'] = $id;
                $user['username'] = null;
                $user['actor'] = null;
                $user['name'] = null;
                $user['type'] = null;
                $user['site'] = null;
                $user['audit'] = $user['audit'] ?? false;
                $user['action'] = $user['action'] ?? false;
                $user['roles'] = [];
            }
        }
        unset($user);
        foreach ($this->actors as $id => $actor) {
            if (!isset($actor['actor'])) {
                $user['user'] = null;
                $user['username'] = null;
                $user['actor'] = $id;
                $user['name'] = null;
                $user['type'] = null;
                $user['site'] = null;
                $user['audit'] = false;
                $user['action'] = $actor['action'];
                $user['roles'] = [];
                $this->users[] = $user;
            } else {
                $actor['user'] = null;
                $actor['audit'] = false;
                $actor['roles'] = [];
                $this->users[] = $actor;
            }
        }

        // REPORT SITES
        $this->write("\nSITES");
        $table = new Table($this->output);
        $table->setHeaders(['ID', 'Description', 'Items']);
        foreach ($this->sites as $site) {
            $table->addRow([$site['id'], $site['description'], $site['items']]);
        }
        $table->render();
        $this->write('');

        // REPORT MODULES
        $this->write("\nMODULES");
        $table = new Table($this->output);
        $table->setHeaders(['Code', 'Description', 'Modtype', 'Table', 'Items']);
        foreach ($this->modules as $module) {
            if (isset($module['shortform']) && $module['shortform'] != 'cor') {
                $table->addRow([$module['shortform'], $module['description'], $module['modtype'], $module['table'], $module['rows']]);
            }
        }
        $table->render();
        $this->write('');

        // REPORT SITE MODULES
        $this->write("\nMODULES AS USED BY SITES");
        $table = new Table($this->output);
        $table->setHeaders(['ID', 'Module', 'Items']);
        foreach ($this->sites as $site) {
            foreach ($site['modules'] as $module => $items) {
                if ($items > 0) {
                    $table->addRow([$site['id'], $module, $items]);
                }
            }
        }
        $table->render();
        $this->write('');

        // REPORT USERS
        $this->write("\nUSERS / ACTORS");
        $table = new Table($this->output);
        $table->setHeaders(['User', 'Username', 'Name', 'Actor', 'Groups', 'Site', 'Audit', 'Action']);
        foreach ($this->users as $id => $user) {
            $table->addRow(
                [
                    $user['user'],
                    $user['username'],
                    $user['name'],
                    $user['actor'],
                    implode(', ', $user['roles']),
                    $user['site'],
                    $user['audit'],
                    $user['action']
                ]
            );
        }
        $table->render();
        $this->write('');

        // REPORT FRAG SCHEMA
        $this->write("\nTYPES AS USED BY MODULES");
        foreach ($this->modules as &$module) {
            if (!isset($module['shortform']) || $module['shortform'] == 'cor' || !isset($this->frags[$module['itemkey']])) {
                continue;
            }
            $module['frags'] = $this->frags[$module['itemkey']];
            ksort($module['frags']);
            $this->write("\n".$module['shortform']);
            $table = new Table($this->output);
            $table->setHeaders(['Class', 'Field', 'Count']);
            foreach ($module['frags'] as $class => &$fields) {
                ksort($fields);
                foreach ($fields as $field => $count) {
                    $table->addRow([$class, $field, $count]);
                }
            }
            $table->render();
        }

        // REPORT FULL SCHEMA
        $this->write("\nTYPES AS DEFINED BY MODULES");
        ksort($this->types);
        foreach ($this->types as $module => &$types) {
            $this->write("\n".$module);
            $table = new Table($this->output);
            $table->setHeaders(['Class', 'Field', 'Value', 'Count']);
            foreach ($types as $class => &$fields) {
                ksort($fields);
                foreach ($fields as $field => &$values) {
                    ksort($values);
                    foreach ($values as $value => $count) {
                        $table->addRow([$class, $field, $value, $count]);
                    }
                }
            }
            $table->render();
        }

        if ($this->exportPath) {
            $this->exportMapping();
        }
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

    private function countItems($table, $site = null)
    {
        $sql = "
            SELECT COUNT(*)
            FROM $table
        ";
        $parms = [];
        if ($site) {
            $sql .= 'WHERE ste_cd = ?';
            $parms[] = $site;
        }

        return $this->source->executeQuery($sql, $parms)->fetch()['COUNT(*)'];
    }

    private function countTypeFrags($type, $field = null)
    {
        if ($type == 'file') {
            return null;
        }
        $typename = $type.'type';
        $sql = "
            SELECT COUNT(*)
            FROM cor_tbl_$type, cor_lut_$typename
            WHERE cor_tbl_$type.$typename = cor_lut_$typename.id
        ";
        $parms = [];
        if ($field) {
            $sql .= "AND cor_lut_$typename.$typename = ?";
            $parms[] = $field;
        }

        return $this->source->executeQuery($sql, $parms)->fetch()['COUNT(*)'];
    }

    private function countAttributeFrags($field, $value = null)
    {
        $sql = '
            SELECT COUNT(*)
            FROM cor_tbl_attribute, cor_lut_attribute, cor_lut_attributetype
            WHERE cor_tbl_attribute.attribute = cor_lut_attribute.id
            AND cor_lut_attribute.attributetype = cor_lut_attributetype.id
            AND cor_lut_attributetype.attributetype = ?
        ';
        $parms[] = $field;
        if ($value) {
            $sql .= 'AND cor_lut_attribute.attribute = ?';
            $parms[] = $value;
        }

        return $this->source->executeQuery($sql, $parms)->fetch()['COUNT(*)'];
    }

    private function summariseTypeFrags($type, $field = null)
    {
        $typename = $type.'type';
        $sql = "
            SELECT cor_tbl_$type.*, cor_lut_$typename.$typename
            FROM cor_tbl_$type, cor_lut_$typename
            WHERE cor_tbl_$type.$typename = cor_lut_$typename.id
        ";
        $parms = [];
        if ($field) {
            $sql .= "AND $typename = ?";
            $parms[] = $field;
        }
        $this->summariseFrags($type, $sql);
    }

    private function summariseFrags($type, $sql, $parms = [])
    {
        $frags = $this->source->fetchAll($sql, $parms);
        $typename = $type.'type';
        foreach ($frags as $frag) {
            $module = $this->getItemkey($frag);
            $field = $frag[$typename];
            if (isset($this->frags[$module][$type][$field])) {
                $this->frags[$module][$type][$field] += 1;
            } else {
                $this->frags[$module][$type][$field] = 1;
            }
            if (isset($frag['actor_itemvalue'])) {
                $this->actors[$frag['actor_itemvalue']]['action'] = true;
            }
            if (isset($frag['cre_by'])) {
                $this->users[$frag['cre_by']]['audit'] = true;
            }
            if (isset($frag['mod_by'])) {
                $this->users[$frag['mod_by']]['audit'] = true;
            }
        }
    }

    private function buildTypes($type, $sql = '')
    {
        $typename = $type.'type';
        $lut = 'cor_lut_'.$typename;
        $tbl = 'cor_tbl_'.$typename;
        if ($sql) {
            $classes = $this->source->fetchAll($sql);
        } else {
            $classes = $this->source->fetchAllTable($lut);
        }
        foreach ($classes as $class) {
            $module = ($class['module'] ?? 'cor');
            $field = $class[$typename];
            if (isset($class[$type])) {
                $this->types[$module][$type][$field][$class[$type]] = $this->countAttributeFrags($field, $class[$type]);
            } else {
                $this->types[$module][$type][$field][''] = $this->countTypeFrags($type, $field);
            }
        }
    }

    private function exportMapping()
    {
        $users = [];
        foreach ($this->users as $user) {
            $map = [];
            $map['source']['name'] = $user['name'] ?? '';
            $map['source']['username'] = $user['username'] ?? '';
            $map['source']['user'] = $user['user'] ?? '';
            $map['source']['actor'] = $user['actor'] ?? '';
            $map['map'] = ($user['audit'] ?? false) || ($user['action'] ?? false);
            $map['user'] = $map['source']['username'];
            $map['actor'] = $map['source']['actor'];
            $map['site'] = $user['site'] ?? '';
            $map['roles'] = $user['roles'] ?? [];
            $users[] = $map;
        }
        ARK::jsonEncodeWrite($users, $this->exportPath.'/users.map.json');
    }
}
