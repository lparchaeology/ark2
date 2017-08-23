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
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Framework\Console\Command;

use ARK\Actor\Actor;
use ARK\Actor\Person;
use ARK\ARK;
use ARK\Database\Console\DatabaseCommand;
use ARK\Framework\Application;
use ARK\ORM\ORM;
use ARK\Security\User;
use ARK\Service;
use ARK\Workflow\Role;
use Exception;

class SiteMigrateLoadCommand extends DatabaseCommand
{
    protected $app;
    protected $sourcePath = '';
    protected $mapPath = '';
    protected $path = '';
    protected $site = '';
    protected $siteKey = '';
    protected $source;
    protected $core;
    protected $data;
    protected $user;
    protected $admin;
    protected $userMap;
    protected $schemaMap;
    protected $mapActor = [];
    protected $mapUser = [];

    protected function configure() : void
    {
        $this->setName('site:migrate:load')
            ->setDescription('Migrate an ARK 1.2 site');
    }

    protected function doExecute()
    {
        // Ask for source
        $path = ARK::varDir().'/migration';
        $sources = ARK::dirList($path);
        $source = $this->askChoice('Please choose the source ARK mapping', $sources);
        $this->mapPath = $path.'/'.$source;
        $source = ARK::jsonDecodeFile($this->mapPath.'/source.json');
        $this->source = $this->getConnection($source['database']);
        $this->source->beginTransaction();
        $this->sourcePath = $source['path'];
        //$this->schemaMap = ARK::jsonDecodeFile($this->mapPath.'/schema.map.json');
        $this->userMap = ARK::jsonDecodeFile($this->mapPath.'/users.map.json');

        $this->site = strtolower($this->askChoice('Please choose the destination ARK instance', ARK::sites()));
        if ($this->site === $this->errorCode()) {
            return $this->errorCode();
        }
        $this->app = new Application($this->site);

        $this->loadUsers();
        return;
        $this->core = Service::database()->core();
        $this->data = Service::database()->data();
        $this->user = Service::database()->user();
        $admin = $this->getServerConfig($this->data->getServer());
        $admin['dbname'] = $this->data->getDatabase();
        $this->admin = $this->getConnection($admin);
        $this->core->beginTransaction();
        $this->data->beginTransaction();
        $this->user->beginTransaction();

        $modRows = $this->core->fetchAllTable('ark_module');
        $hasSiteMod = false;
        foreach ($modRows as $mod) {
            if (!$mod['core']) {
                $destModChoices[] = $mod['module'];
            }
            if ($mod['module'] === 'site') {
                $hasSiteMod = true;
            }
            $destMod[$mod['module']] = $mod;
        }

        $schemaRows = $this->core->fetchAllTable('ark_schema');
        foreach ($schemaRows as $schema) {
            $destSchema[$schema['module']][] = $schema['schma'];
        }

        $mapping = $this->schemaMap['modules'];
        foreach (array_keys($mapping) as $mod) {
            $modCodes[] = $mod.'_cd';
        }

        $this->write("\nThe following modules will be migrated:");
        $headers = ['Old', 'New', 'Schema', 'Entity', 'Table'];
        $rows = [];
        foreach ($mapping as $mod => $module) {
            $rows[] = [$mod, $module['module'], $module['schema'], $module['config']['entity'], $module['config']['tbl']];
        }
        unset($module);
        $this->writeTable($headers, $rows);
        if (!$this->askConfirmation('Please confirm you want to use this mapping', true)) {
            return $this->errorCode();
        }
        $this->write('');

        // * SITE MODULE * //
        if (!$hasSiteMod) {
            $module['module'] = 'site';
            $module['resource'] = 'sites';
            $module['project'] = 'ARK';
            $module['namespace'] = 'ARK\Entity';
            $module['entity'] = 'Site';
            $module['classname'] = 'ARK\Entity\Site';
            $module['tbl'] = 'ark_item_site';
            $module['core'] = true;
            $module['keyword'] = 'core.module.site';
            $this->addTranslation($module['keyword'], $module['entity']);
            $this->core->insert('ark_module', $module);
            unset($module);
        }
        if (!$this->data->tableExists('ark_item_site')) {
            $this->data->createItemTable('site');
        }
        $sites = $this->source->fetchAllTable('cor_tbl_ste', []);
        foreach ($sites as $site) {
            if ($site['id'] !== 'ARK') {
                $item = [
                    'item' => $site['id'],
                    'module' => 'site',
                    'schma' => 'core.site',
                    'idx' => $site['id'],
                    'label' => $site['id'],
                    'creator' => $site['cre_by'],
                    'created' => $site['cre_on'],
                    'version' => '',
                ];
                try {
                    $this->data->insert('ark_item_site', $item);
                } catch (Exception $e) {
                }
                $text = [
                    'module' => 'site',
                    'item' => $site['id'],
                    'attribute' => 'name',
                    'parameter' => 'en',
                    'value' => $site['id'],
                    'version' => '',
                ];
                $this->data->insert('ark_fragment_text', $text);
            }
        }

        // * MODULE SCHEMA * //
        foreach ($mapping as $mod => &$module) {
            if ($module['mode'] === 'new') {
                $this->addTranslation($module['config']['keyword'], $module['config']['entity']);
                $this->core->insert('ark_module', $module['config']);
                if (!$this->data->tableExists($module['config']['tbl'])) {
                    $this->data->createItemTable($module['module']);
                }
            }
            $schema = $this->core->fetchArray('SELECT * FROM ark_schema WHERE schma = ?', [$module['schema']]);
            $type = null;
            $typeVocabulary = null;
            if (!$schema) {
                $modtypeTable = $mod.'_lut_'.$mod.'type';
                try {
                    $modtypes = $this->source->fetchAllTable($modtypeTable);
                } catch (Exception $e) {
                    $modtypes = false;
                }
                if ($modtypes) {
                    $type = 'type';
                    $typeVocabulary = $module['schema'].'.type';
                    $module['type'] = $typeVocabulary;
                    $module['modtype'] = $mod.'type';
                    $module['lut'] = $modtypeTable;
                    $typeEntities = true;
                    $vocab['concept'] = $typeVocabulary;
                    $vocab['type'] = 'list';
                    $vocab['source'] = 'ARK 1.2';
                    $vocab['description'] = $typeVocabulary;
                    $vocab['keyword'] = $typeVocabulary;
                    $this->addTranslation($vocab['keyword'], $vocab['concept']);
                    $this->core->insert('ark_vocabulary', $vocab);
                    $term['concept'] = $typeVocabulary;
                    foreach ($modtypes as $modtype) {
                        $term['term'] = strtolower($modtype[$mod.'type']);
                        $term['keyword'] = $term['concept'].'.'.$term['term'];
                        $this->addTranslation($term['keyword'], $term['term']);
                        $this->core->insert('ark_vocabulary_term', $term);
                    }
                } else {
                    $module['type'] = null;
                    $module['modtype'] = false;
                    $module['lut'] = null;
                }
                $schema['schma'] = $module['schema'];
                $schema['module'] = $module['module'];
                $schema['generator'] = 'sequence';
                $schema['sequence'] = 'id';
                $schema['type'] = $type;
                $schema['vocabulary'] = $typeVocabulary;
                $schema['keyword'] = $module['schema'].'.schema';
                $this->addTranslation($schema['keyword'], $schema['schma']);
                $this->core->insert('ark_schema', $schema);
            } else {
                $module['type'] = null;
                $module['modtype'] = false;
                $module['lut'] = null;
            }
        }
        unset($module);

        // * ATTRIBUTE TYPES TO VOCABULARY TYPES * //
        $types = $this->source->fetchAllTable('cor_lut_attributetype');
        foreach ($types as $type) {
            $vocab['concept'] = strtolower($this->siteKey.'.'.$type['attributetype']);
            $vocab['type'] = 'list';
            $vocab['source'] = 'ARK 1.2';
            $vocab['keyword'] = $vocab['concept'];
            $this->addTranslation($vocab['keyword'], $vocab['concept']);
            $this->core->insert('ark_vocabulary', $vocab);
        }
        $sql = '
            SELECT cor_lut_attribute.*, cor_lut_attributetype.attributetype
            FROM cor_lut_attribute, cor_lut_attributetype
            WHERE cor_lut_attribute.attributetype = cor_lut_attributetype.id
        ';
        $attributes = $this->source->fetchAll($sql);
        foreach ($attributes as $attribute) {
            $term['concept'] = strtolower($this->siteKey.'.'.$attribute['attributetype']);
            $term['term'] = $this->makeAttribute($attribute['attribute']);
            $term['keyword'] = $term['concept'].'.'.$term['term'];
            $this->addTranslation($term['keyword'], $term['term']);
            // There can be duplicate values!
            try {
                $this->core->insert('ark_vocabulary_term', $term);
            } catch (Exception $e) {
                $this->write('Duplicate Vocabulary term skipped : '.$term['concept'].' '.$term['term']);
            }
        }

        // * COPY MODULE ITEMS * //
        foreach ($mapping as $mod => $module) {
            $old_tbl = $mod.'_tbl_'.$mod;
            $itemkey = $mod.'_cd';
            $new_tbl = $module['config']['tbl'];
            if ($module['modtype']) {
                $modtype = $module['modtype'];
                $lut = $module['lut'];
                $sql = "
                    SELECT $old_tbl.$itemkey AS itemkey, $lut.$modtype AS modtype, $old_tbl.cre_by, $old_tbl.cre_on
                    FROM $old_tbl, $lut
                    WHERE $old_tbl.$modtype = $lut.id
                ";
            } else {
                $sql = "
                    SELECT $old_tbl.$itemkey AS itemkey, $old_tbl.cre_by, $old_tbl.cre_on
                    FROM $old_tbl
                ";
            }
            $items = $this->source->fetchAll($sql, []);
            $updates = 0;
            $count = count($items);
            $this->write($old_tbl.' : '.$count);
            if ($count > 0) {
                $this->progress->start($count);
                foreach ($items as $item) {
                    $this->progress->advance();
                    $newItem = $this->makeItemKey($item['itemkey']);
                    $newItem['module'] = $module['module'];
                    $newItem['schma'] = $module['schema'];
                    $newItem['type'] = (isset($item['modtype']) ? strtolower($item['modtype']) : '');
                    $newItem['creator'] = $item['cre_by'];
                    $newItem['created'] = $item['cre_on'];
                    $this->data->insert($module['config']['tbl'], $newItem);
                    $updates = $updates + 1;
                }
                $this->progress->finish();
            }
            $this->write("\n".$module['config']['tbl']." : $updates\n");
        }
        unset($module);

        // * COPY FILE ITEMS * /
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
            if (in_array($row['filetype'], ['image', 'images', 'drawing'], true)) {
                $item['type'] = 'image';
            }
            if ($row['filetype'] === 'sheet') {
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
            if (!in_array($row['itemkey'], $modCodes, true)) {
                continue;
            }
            $key = $this->makeItemKey($row['itemvalue']);
            if ($row['filetype'] === 'images') {
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

        // * COPY FRAGMENTS * //
        $parents = [];
        $classes = [
            'action' => 'ark_fragment_item',
            'attribute' => 'ark_fragment_string',
            'date' => 'ark_fragment_date',
            'number' => 'ark_fragment_integer',
            'txt' => 'ark_fragment_text',
        ];
        foreach ($classes as $dataclass => $new_tbl) {
            if ($new_tbl === '') {
                continue;
            }

            // Add temp chain fields
            $this->addChainFields($new_tbl);

            $type = $dataclass.'type';
            $old_tbl = 'cor_tbl_'.$dataclass;
            $lut = 'cor_lut_'.$type;
            if ($dataclass === 'attribute') {
                $sql = '
                    SELECT cor_tbl_attribute.*, cor_lut_attribute.attribute, cor_lut_attributetype.attributetype
                    FROM cor_tbl_attribute, cor_lut_attribute, cor_lut_attributetype
                    WHERE cor_tbl_attribute.attribute = cor_lut_attribute.id
                    AND cor_lut_attribute.attributetype = cor_lut_attributetype.id
                ';
                $attributes['format'] = 'identifier';
            } elseif ($dataclass === 'action') {
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
            $frags = $this->source->fetchAll($sql, []);
            $count = count($frags);
            $this->write($old_tbl.' : '.$count);
            $updates = 0;
            if ($count) {
                $this->progress->start($count);
            }
            foreach ($frags as $frag) {
                $this->progress->advance();
                if (substr($frag['itemkey'], 0, 11) === 'cor_tbl_map') {
                    $this->write('Skipping map frag : '.$frag['id'].' : '.$frag['itemkey'].' : '.$frag['itemvalue']);
                    continue;
                }
                // Skip if parent is a lut
                if (substr($frag['itemkey'], 0, 8) === 'cor_lut_') {
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
                if ($frag['itemkey'] === null) {
                    $this->write('Skipping orphan frag : '.$frag['id'].' : '.$frag['old_parent_table'].' : '.$frag['old_parent_id']);
                    continue;
                }
                if (!in_array($frag['itemkey'], $modCodes, true)) {
                    //$this->write('Skipping frag for invalid mod_cd : '.$frag['itemkey']);
                    continue;
                }
                $module = $mapping[substr($frag['itemkey'], 0, 3)]['module'];
                if ($dataclass === 'attribute') {
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
            if (!in_array($row['itemkey'], $modCodes, true)) {
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
        // TODO Chains?
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
            if (!in_array($row['itemkey'], $modCodes, true) || !in_array($row['xmi_itemkey'], $modCodes, true)) {
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
        $this->data->commit();

        $this->data->beginTransaction();
        $objects = $this->data->fetchAllTable('ark_fragment_object');
        foreach ($objects as $object) {
            foreach ($fragmentTables as $fragmentTable) {
                $upd = "
                    UPDATE $fragmentTable
                    SET object = :fid
                    WHERE old_parent_table = :old_table
                    AND old_parent_id = :old_id
                ";
                $params = [
                    ':fid' => $object['fid'],
                    ':old_table' => $object['old_table'],
                    ':old_id' => $object['old_id'],
                ];
                $this->data->executeUpdate($upd, $params);
            }
        }
        $this->data->commit();

        // Update the old parent attribute if mapped
        $this->data->beginTransaction();
        foreach ($objects as $object) {
            $fragTable = $chainTables[$object['old_table']];
            if (isset($chainMap[$object['attribute']])) {
                $attribute = $chainMap[$object['attribute']]['object'];
                $parent = $chainMap[$object['attribute']]['parent'];
            } else {
                $attribute = $object['attribute'].'_obj';
                $parent = null;
            }
            if ($parent) {
                $sql = "
                    SELECT *
                    FROM $fragTable
                    WHERE old_table = :old_table
                    AND old_id = :old_id
                ";
                $params = [
                    ':old_table' => $object['old_table'],
                    ':old_id' => $object['old_id'],
                ];
                $frag = $this->data->fetchAssoc($sql, $params);
                $upd = "
                    UPDATE $fragTable
                    SET attribute = :attribute
                    WHERE fid = :fid
                ";
                $params = [
                    ':fid' => $frag['fid'],
                    ':attribute' => $parent,
                ];
                $this->data->executeUpdate($upd, $params);
            }
            $upd = '
                UPDATE ark_fragment_object
                SET attribute = :attribute
                WHERE fid = :fid
            ';
            $params = [
                ':fid' => $object['fid'],
                ':attribute' => $attribute,
            ];
            $this->data->executeUpdate($upd, $params);
        }
        $this->data->commit();
        foreach ($fragmentTables as $fragmentTable) {
            $this->removeChainFields($fragmentTable);
        }
        $this->removeChainFields('ark_fragment_object');
        $this->write("\nTotal chains migrated : ".count($objects));

        // * DONE! * //
        $this->write("\nMigration Complete!");
    }

    private function loadUsers() : void
    {
        foreach ($this->userMap as $map) {
            if (!$map['map']) {
                continue;
            }

            if ($map['user']) {
                $this->mapUser[$map['user']] = $map['id'];
            }
            if ($map['actor']) {
                $this->mapActor[$map['actor']] = $map['id'];
            }

            $actor = ORM::find(Actor::class, $map['id']);
            $user = ORM::find(User::class, $map['id']);

            if (!$actor || !$user) {
                if (!$actor && $map['actor']) {
                    $actor = new Person();
                    $actor->setItem($map['id']);
                    ORM::persist($actor);
                    $this->mapAbk[$map['actor']] = $map['id'];
                }
                if (!$user && $map['user']) {
                    $user = Service::security()->createUser(
                        $map['id'],
                        $map['email'],
                        $map['password'],
                        $map['name'],
                        $map['level']
                    );
                }
                if ($actor && $user) {
                    Service::security()->createActorUser($actor, $user);
                }
            }
            if ($actor) {
                foreach ($map['roles'] as $role) {
                    $role = ORM::find(Role::class, $role);
                    Service::security()->createActorRole($actor, $role);
                }
            }
            Service::security()->registerUser($user, $actor);
        }
    }

    private function addTranslation($keyword, $text = null, $title = true) : void
    {
        // May already exist
        try {
            $trans['keyword'] = $keyword;
            $trans['domain'] = 'core';
            $this->core->insert('ark_translation', $trans);
        } catch (Exception $e) {
        }
        // May already exist
        try {
            if ($text) {
                $msg['language'] = 'en';
                $msg['keyword'] = $keyword;
                $msg['role'] = 'default';
                $msg['text'] = $title ? ucwords($text) : $text;
                $this->core->insert('ark_translation_message', $msg);
            }
        } catch (Exception $e) {
        }
    }

    private function makeAttribute($attribute)
    {
        if (isset(self::$attributes[$attribute])) {
            return self::$attributes[$attribute];
        }
        $attribute = str_replace(' ', '', $attribute);
        $attribute = str_replace('.', '', $attribute);
        $attribute = str_replace('?', '', $attribute);
        $attribute = str_replace('!', '', $attribute);
        $attribute = str_replace('/', '', $attribute);
        $attribute = str_replace('\\', '', $attribute);
        $attribute = str_replace('_', '', $attribute);
        $attribute = str_replace('-', 'to', $attribute);
        $attribute = str_replace(':', 'to', $attribute);
        $attribute = str_replace('%', 'pcnt', $attribute);

        return strtolower($attribute);
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

    private function addChainFields($table) : void
    {
        // Add temp chain fields
        $schema_new = $this->admin->getSchemaManager()->createSchema();
        $schema = clone $schema_new;
        if (!$schema->getTable($table)->hasColumn('old_table')) {
            $schema->getTable($table)->addColumn('old_table', 'string', ['length' => 50, 'notnull' => false]);
        }
        if (!$schema->getTable($table)->hasColumn('old_id')) {
            $schema->getTable($table)->addColumn('old_id', 'integer', ['notnull' => false]);
            $schema->getTable($table)->addIndex(['old_table', 'old_id'], 'old_child');
        }
        if (!$schema->getTable($table)->hasColumn('old_parent_table')) {
            $schema->getTable($table)->addColumn('old_parent_table', 'string', ['length' => 50, 'notnull' => false]);
        }
        if (!$schema->getTable($table)->hasColumn('old_parent_id')) {
            $schema->getTable($table)->addColumn('old_parent_id', 'integer', ['notnull' => false]);
            $schema->getTable($table)->addIndex(['old_parent_table', 'old_parent_id'], 'old_parent');
        }
        $changes = $schema_new->getMigrateToSql($schema, $this->admin->getDatabasePlatform());
        foreach ($changes as $sql) {
            $this->admin->executeUpdate($sql, []);
        }
    }

    private function removeChainFields($table) : void
    {
        $schema_new = $this->admin->getSchemaManager()->createSchema();
        $schema = clone $schema_new;
        if ($schema->getTable($table)->hasColumn('old_table')) {
            $schema->getTable($table)->dropColumn('old_table');
        }
        if ($schema->getTable($table)->hasColumn('old_id')) {
            $schema->getTable($table)->dropColumn('old_id');
        }
        if ($schema->getTable($table)->hasColumn('old_parent_table')) {
            $schema->getTable($table)->dropColumn('old_parent_table');
        }
        if ($schema->getTable($table)->hasColumn('old_parent_id')) {
            $schema->getTable($table)->dropColumn('old_parent_id');
        }
        $changes = $schema_new->getMigrateToSql($schema, $this->admin->getDatabasePlatform());
        foreach ($changes as $sql) {
            $this->admin->executeUpdate($sql, []);
        }
    }
}
