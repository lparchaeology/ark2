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

    protected $site = '';
    protected $siteKey = '';
    protected $source = null;
    protected $admin = null;

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

        // MODULES
        $modules = $this->source->fetchAllTable('cor_tbl_module');
        $this->write("\nThe following modules exist:");
        $table = new Table($this->output);
        $table->setHeaders(['Code', 'Description', 'Modtype', 'Table', 'Rows']);
        foreach ($modules as &$module) {
            $mod = $module['shortform'];
            if ($mod == 'cor') {
                continue;
            }
            $module['table'] = $mod.'_tbl_'.$mod;
            $module['rows'] = $this->source->countRows($module['table']);
            $module['modtype'] = $mod.'type';
            $module['lut'] = $mod.'_lut_'.$module['modtype'];
            $module['modtypes'] = [];
            if ($this->source->tableExists($module['lut'])) {
                $modtypes = $this->source->fetchAllTable($module['lut']);
                foreach ($modtypes as $modtype) {
                    $module['modtypes'][] = strtolower($modtype[$module['modtype']]);
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

        // SITES
        $this->write("\nThe following sites exist:");
        $sites = $this->source->fetchAllTable('cor_tbl_ste');
        $table = new Table($this->output);
        $table->setHeaders(['ID', 'Description']);
        foreach ($sites as $site) {
            $table->addRow([$site['id'], $site['description']]);
        }
        $table->render();
        $this->write('');

        // TYPES
        $this->write("\nThe following attribute types exist:");
        $types = $this->source->fetchAllTable('cor_lut_attributetype');
        foreach ($types as $type) {
            $sql = '
                SELECT cor_lut_attribute.*, cor_lut_attributetype.attributetype
                FROM cor_lut_attribute, cor_lut_attributetype
                WHERE cor_lut_attribute.attributetype = :type
                AND cor_lut_attribute.attributetype = cor_lut_attributetype.id
            ';
            $values = $this->source->fetchAll($sql, [':type' => $type['id']]);
            $this->write("\n  ".$type['attributetype'].' ['.$type['module'].'] ('.count($values).')');
            foreach ($values as $value) {
                $this->write('    '.$value['attribute']);
            }
        }
        $this->write('');

        $files = $this->source->countRows('cor_lut_file');
/*
        // FILES
        $sql = '
            SELECT cor_lut_file.*, cor_lut_filetype.filetype
            FROM cor_lut_file, cor_lut_filetype
            WHERE cor_lut_file.filetype = cor_lut_filetype.id
        ';
        $rows = $this->source->fetchAllTable('cor_lut_file');
        $count = count($rows);
        $this->write('cor_lut_file : '.$count);
        if ($count) {
            $this->progress->start($count);
        }
        $updates = 0;
        foreach ($rows as $row) {
            $this->progress->advance();
            $item = [
                'item' => $row['id'],
                'module' => 'file',
                'schma' => 'core.file',
                'type' => 'other',
                'idx' => $row['id'],
                'label' => $row['filename'],
                'creator' => $row['cre_by'],
                'created' => $row['cre_on'],
            ];
            if (in_array($row['filetype'], ['image', 'images', 'drawing'])) {
                $item['type'] = 'image';
            }
            if ($row['filetype'] == 'sheet') {
                $item['type'] = 'document';
            }
            $this->data->insert('ark_item_file', $item);
            $updates = $updates + 1;
        }
        $this->progress->finish();
        $this->write("\nark_item_file : $updates\n");
        $updates = 0;
        $sql = '
            SELECT cor_tbl_file.*, cor_lut_filetype.filetype
            FROM cor_tbl_file, cor_lut_file, cor_lut_filetype
            WHERE cor_tbl_file.file = cor_lut_file.id
            AND cor_lut_file.filetype = cor_lut_filetype.id
        ';
        $rows = $this->source->fetchAll($sql, []);
        $count = count($rows);
        $this->write('cor_tbl_file : '.$count);
        if ($count) {
            $this->progress->start($count);
        }
        foreach ($rows as $row) {
            $this->progress->advance();
            if (!in_array($row['itemkey'], $modCodes)) {
                continue;
            }
            $key = $this->makeItemKey($row['itemvalue']);
            if ($row['filetype'] == 'images') {
                $row['filetype'] = 'image';
            }
            $frag = [
                'module' => $mapping[substr($row['itemkey'], 0, 3)]['module'],
                'item' => $key['item'],
                'attribute' => $row['filetype'],
                'parameter' => 'file',
                'value' => $row['file'],
            ];
            $this->data->insert('ark_fragment_item', $frag);
            $updates = $updates + 1;
        }
        $this->progress->finish();
        $this->write("\nark_fragment_item : $updates\n");

        // FRAGMENTS
        $parents = [];
        $classes = [
            'action' => 'ark_fragment_item',
            'attribute' => 'ark_fragment_string',
            'date' => 'ark_fragment_date',
            'number' => 'ark_fragment_integer',
            'txt' => 'ark_fragment_text',
        ];
        foreach ($classes as $dataclass => $new_tbl) {
            $type = $dataclass.'type';
            $old_tbl = 'cor_tbl_'.$dataclass;
            $lut = 'cor_lut_'.$type;
            if ($dataclass == 'attribute') {
                $sql = '
                    SELECT cor_tbl_attribute.*, cor_lut_attribute.attribute, cor_lut_attributetype.attributetype
                    FROM cor_tbl_attribute, cor_lut_attribute, cor_lut_attributetype
                    WHERE cor_tbl_attribute.attribute = cor_lut_attribute.id
                    AND cor_lut_attribute.attributetype = cor_lut_attributetype.id
                ';
                $attributes['format'] = 'identifier';
            } elseif ($dataclass == 'action') {
                $sql = '
                    SELECT cor_tbl_action.*, cor_lut_actiontype.actiontype
                    FROM cor_tbl_action, cor_lut_actiontype
                    WHERE cor_tbl_action.actiontype = cor_lut_actiontype.id
                ';
                $attributes['format'] = 'actor';
            } else {
                $sql = "
                    SELECT $old_tbl.*, $lut.$type AS $type
                    FROM $old_tbl, $lut
                    WHERE $old_tbl.$type = $lut.id
                ";
            }
            $frags = $this->source->fetchAll($sql);
            $count = count($frags);
            $this->write($old_tbl.' : '.$count);
            $updates = 0;
            if ($count) {
                $this->progress->start($count);
            }
            foreach ($frags as $frag) {
                $this->progress->advance();
                if (substr($frag['itemkey'], 0, 11) == 'cor_tbl_map') {
                    $this->write('Skipping map frag : '.$frag['id'].' : '.$frag['itemkey'].' : '.$frag['itemvalue']);
                    continue;
                }
                // Skip if parent is a lut
                if (substr($frag['itemkey'], 0, 8) == 'cor_lut_') {
                    $this->write('Skipping lut frag : '.$frag['id'].' : '.$frag['itemkey'].' : '.$frag['itemvalue']);
                    continue;
                }
                // If itemkey/itemvalue is a chain reference, replace with actual item
                if ($this->source->tableExists($frag['itemkey'])) {
                    $frag['old_parent_table'] = $frag['itemkey'];
                    $frag['old_parent_id'] = $frag['itemvalue'];
                    $frag = array_merge($frag, $this->getParent($this->source, $frag['itemkey'], $frag['itemvalue']));
                }
                // Skip if parent doesn't exist, i.e. orphaned frag!
                if ($frag['itemkey'] == null) {
                    $this->write('Skipping orphan frag : '.$frag['id'].' : '.$frag['old_parent_table'].' : '.$frag['old_parent_id']);
                    continue;
                }
                if (!in_array($frag['itemkey'], $modCodes)) {
                    $this->write('Skipping frag for invalid mod_cd : '.$frag['itemkey']);
                    continue;
                }
                $module = $mapping[substr($frag['itemkey'], 0, 3)]['module'];
                if ($dataclass == 'attribute') {
                    $frag['parameter'] = $this->siteKey.'.'.$frag['attributetype'];
                    $frag['value'] = $this->makeAttribute($frag['attribute']);
                    $attribute['vocabulary'] = $frag['parameter'];
                    unset($frag['attribute'], $frag['boolean']);
                }
                if (isset($frag[$type])) {
                    $frag['attribute'] = $frag[$type];
                    unset($frag[$type]);
                }
                $frag['old_table'] = $old_tbl;
                $frag['old_id'] = $frag['id'];
                unset($frag['id'], $frag['typemod'], $frag['fragtype'], $frag['fragid']);

                if (isset($frag['itemkey'])) {
                    $frag['module'] = $module;
                }
                if (isset($frag['actor_itemkey'])) {
                    $frag['parameter'] = $mapping[substr($frag['actor_itemkey'], 0, 3)]['module'];
                    $key = $this->makeItemKey($frag['actor_itemvalue']);
                    $frag['value'] = $key['item'];
                    unset($frag['actor_itemkey'], $frag['actor_itemvalue']);
                }
                $key = $this->makeItemKey($frag['itemvalue']);
                $frag['item'] = $key['item'];
                unset($frag['itemkey'], $frag['itemvalue']);

                if (isset($frag['date'])) {
                    $frag['value'] = $frag['date'];
                    unset($frag['date']);
                }
                if (isset($frag['number'])) {
                    $frag['value'] = $frag['number'];
                    unset($frag['number']);
                }
                if (isset($frag['txt'])) {
                    $frag['value'] = $frag['txt'];
                    $frag['parameter'] = $frag['language'];
                    unset($frag['txt'], $frag['language']);
                }
                if (isset($frag['cre_by'])) {
                    $frag['creator'] = $frag['cre_by'];
                    unset($frag['cre_by']);
                }
                if (isset($frag['cre_on'])) {
                    $frag['created'] = $frag['cre_on'];
                    unset($frag['cre_on']);
                }
                $this->data->insert($new_tbl, $frag);
                $updates = $updates + 1;
            }
            $this->progress->finish();
            $this->write("\n$new_tbl : $updates\n");
        }

        // * COPY SPANS * //
        // TODO Other span types than tvector/sameas
        // TODO Chains?
        $updates = 0;
        $sql = '
            SELECT cor_tbl_span.*, cor_lut_spantype.spantype
            FROM cor_tbl_span, cor_lut_spantype
            WHERE cor_tbl_span.spantype = cor_lut_spantype.id
        ';
        $rows = $this->source->fetchAll($sql, []);
        $count = count($rows);
        $this->write('cor_tbl_span : '.$count);
        if ($count) {
            $this->progress->start($count);
        }
        foreach ($rows as $row) {
            $this->progress->advance();
            if (!in_array($row['itemkey'], $modCodes)) {
                continue;
            }
            $module = $mapping[substr($row['itemkey'], 0, 3)]['module'];
            $key = $this->makeItemKey($row['itemvalue']);
            $item = $key['item'];
            $key = $this->makeItemKey($row['beg']);
            $value = $key['item'];
            $key = $this->makeItemKey($row['end']);
            $extent = $key['item'];
            $frag = [
                'module' => $module,
                'item' => $item,
                'attribute' => $row['spantype'],
                'parameter' => $module,
                'value' => $value,
                'span' => true,
                'extent' => $extent,
            ];
            $this->data->insert('ark_fragment_item', $frag);
            $updates = $updates + 1;
        }
        $this->progress->finish();
        $this->write("\nark_fragment_item : $updates\n");

        // * COPY XMIS * //
        $updates = 0;
        $sql = "
            SELECT *
            FROM $old_tbl
        ";
        $rows = $this->source->fetchAllTable('cor_tbl_xmi');
        $count = count($rows);
        $this->write('cor_tbl_xmi : '.$count);
        if ($count) {
            $this->progress->start($count);
        }
        foreach ($rows as $row) {
            $this->progress->advance();
            if (!in_array($row['itemkey'], $modCodes) || !in_array($row['xmi_itemkey'], $modCodes)) {
                continue;
            }
            $module1 = $mapping[substr($row['itemkey'], 0, 3)]['module'];
            $key = $this->makeItemKey($row['itemvalue']);
            $item1 = $key['item'];
            $module2 = $mapping[substr($row['xmi_itemkey'], 0, 3)]['module'];
            $key = $this->makeItemKey($row['xmi_itemvalue']);
            $item2 = $key['item'];
            $association = [
                'module1' => $module1,
                'item1' => $item1,
                'association' => 'xmi',
                'module2' => $module2,
                'item2' => $item2,
            ];
            $this->data->insert('ark_association', $association);
            $updates = $updates + 1;
        }
        $this->progress->finish();
        $this->write("\nark_association : $updates\n");

        // Commit now so available for chaining
        $this->data->commit();
        $this->core->commit();
        $this->user->commit();

        // * CHAIN, CHAIN, CHAIN, CHAIN 'O FOOLS * //
        $this->write("\n* Linking Chains *\n");
        $fragmentTables = [
            'ark_fragment_date',
            'ark_fragment_integer',
            'ark_fragment_item',
            'ark_fragment_string',
            'ark_fragment_text',
        ];
        $chainTables = [
            'cor_tbl_action' => 'ark_fragment_item',
            'cor_tbl_attribute' => 'ark_fragment_string',
            'cor_tbl_date' => 'ark_fragment_date',
            'cor_tbl_number' => 'ark_fragment_integer',
            'cor_tbl_txt' => 'ark_fragment_text',
        ];
        $chainMap = [
            'interp' => ['object' => 'interpretation', 'parent' => 'interpretedas'],
            'sgrnarrative' => ['object' => 'narrative', 'parent' => 'narratedas'],
        ];
        // Add temp chain fields
        $this->addChainFields('ark_fragment_object');
        $this->data->beginTransaction();
        $objects = [];
        foreach ($fragmentTables as $fragmentTable) {
            $sql = "
                SELECT *
                FROM $fragmentTable
                WHERE NULLIF(old_parent_table, '') IS NOT NULL
            ";
            $frags = $this->data->fetchAll($sql);
            $this->write("$fragmentTable chained fragments : ".count($frags));
            foreach ($frags as $frag) {
                $objects[$frag['old_parent_table']][$frag['old_parent_id']] = true;
            }
        }
        foreach ($objects as $old_parent_table => $parents) {
            $this->write("\n$old_parent_table chains : ".count($parents));
            $fragTable = $chainTables[$old_parent_table];
            $sql = "
                SELECT *
                FROM $fragTable
                WHERE old_table = :old_table
                AND old_id = :old_id
            ";
            $params[':old_table'] = $old_parent_table;
            $upd = "
                UPDATE $fragTable
                SET old_parent_table = old_table, old_parent_id = old_id
                WHERE fid = :fid
            ";
            $old_parent_ids = array_keys($parents);
            foreach ($old_parent_ids as $old_parent_id) {
                $params[':old_id'] = $old_parent_id;
                $object = $this->data->fetchAssoc($sql, $params);
                $this->data->executeUpdate($upd, ['fid' => $object['fid']]);
                $object['fid'] = $this->data->generateSequence('object', '', 'fid');

                $object['type'] = 'object';
                unset($object['format'], $object['parameter']);

                $object['value'] = '';
                unset($object['old_parent_table'], $object['old_parent_id']);

                $this->data->insert('ark_fragment_object', $object);
            }
        }

        $this->write("\nTotal chains : ".count($objects));
        */
    }

    private function makeItemKey($itemvalue)
    {
        $parts = explode('_', $itemvalue);
        if (count($parts) > 1) {
            return [
                'item' => $parts[0].'.'.$parts[1],
                'parent_module' => 'site',
                'parent_item' => $parts[0],
                'idx' => $parts[1],
                'label' => $itemvalue,
            ];
        }

        return [
            'item' => $itemvalue,
            'parent_module' => null,
            'parent_item' => null,
            'idx' => $itemvalue,
            'label' => $itemvalue,
        ];
    }

    private function getParent($conn, $tbl, $id)
    {
        $sql = "
            SELECT *
            FROM $tbl
            WHERE id = ?
        ";
        $parent = $conn->fetchAssoc($sql, [$id]);
        if ($parent['itemkey'] && $conn->tableExists($parent['itemkey'])) {
            return $this->getParent($conn, $parent['itemkey'], $parent['itemvalue']);
        }

        return ['itemkey' => $parent['itemkey'], 'itemvalue' => $parent['itemvalue']];
    }
}
