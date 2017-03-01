<?php

/**
 * ARK Console Command
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
 * @php        >=5.6, >=7.0
 */

namespace ARK\Console\System\Command;

use ARK\ARK;
use ARK\Console\ProcessTrait;
use ARK\Console\ConsoleCommand;
use ARK\Database\Console\DatabaseCommand;
use Doctrine\DBAL\DBALException;
use Exception;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SiteMigrateCommand extends DatabaseCommand
{
    use ProcessTrait;

    protected static $attributes = [
        '<5%' => 'lt5pcnt',
        '5-20%' => '5to20pcnt',
        '20-40%' => '20to40pcnt',
        '40-60%' => '40to60pcnt',
        '60-80%' => '60to80pcnt',
        '80-100%' => '80to100pcnt',
        '1:1' => 'ratio1to1',
        '1:10' => 'ratio1to10',
        '1:20' => 'ratio1to20',
        '0.2m' => '02m',
        '0.3m' => '03m',
        '0.3m0.2m' => '03m02m',
        '0.2m1m' => '02m1m',
        '1m0.5m' => '1m05m',
        '1m0.3m' => '1m03m',
        '0.5m' => '05m',
        '0.5m0.2m' => '05m02m',
        '0.3m1m' => '03m1m',
        '0.2m0.5m' => '02m05m',
        '0.3m0.5m' => '03m05m',
        '0.5m0.2' => '05m02',
        '0.2m0.5m1m' => '02m05m1m',
        '0.2m0.2m' => '02m02m',
        'c.t.p.' => 'ctp',
        'n/a' => 'na',
        'rb??' => 'rbq',
        'n/a_1' => 'na_1',
        'n/a_2' => 'na_2',
    ];

    protected function configure()
    {
        $this->setName('site:migrate')
             ->setDescription('Migrate an ARK 1.2 site');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        // Ask if migrate to new or existing site
        $migrate = $this->askChoice('Do you want to migrate to a new site or an existing site?', ['New', 'Existing'], 'New');

        // If new, create by calling create
        if (strtolower($migrate) == 'new') {
            $site = $this->runCommand('site:create');
            $key = $site;
        } else {
            $site = $this->askChoice('Please choose the site to migrate into', ARK::sites());
            $key = $this->askQuestion('Please enter a unique key for the site being migrated');
        }
        if ($site === ConsoleCommand::ERROR_CODE) {
            return ConsoleCommand::ERROR_CODE;
        }
        $destinationConfig = ARK::siteDatabaseConfig($site, true);
        // Clone old database and get clone connection
        $clone = $this->askChoice('Do you want to clone the database or an use an existing clone?', ['Clone', 'Existing'], 'Clone');
        // TODO Only list databases with cor_tbl_module in them?
        if (strtolower($clone) == 'new') {
            $sourceConfig = $this->runCommand('database:clone');
        } else {
            $sourceConfig = $this->chooseDatabaseConfig();
        }
        if (!is_array($sourceConfig)) {
            return ConsoleCommand::ERROR_CODE;
        }
        $source = $this->getConnection($sourceConfig);
        $source->beginTransaction();

        // Do any fixes?

        // Set up modules in new, loop through list asking required details, choose schema, etc, create data tables
        $newChoice = 'Create New Module';
        $skipChoice = 'Skip This Module';
        $destModChoices = [$newChoice, $skipChoice];
        $core = $this->getConnection($destinationConfig['core']);
        $data = $this->getConnection($destinationConfig['data']);
        $user = $this->getConnection($destinationConfig['user']);
        $core->beginTransaction();
        $data->beginTransaction();
        $user->beginTransaction();
        $modRows = $core->fetchAllTable('ark_module');
        $hasSiteMod = false;
        foreach ($modRows as $mod) {
            if (!$mod['core']) {
                $destModChoices[] = $mod['module'];
            }
            if ($mod['module'] == 'site') {
                $hasSiteMod = true;
            }
            $destMod[$mod['module']] = $mod;
        }

        $srcMods = $source->fetchAllTable('cor_tbl_module');
        $this->write("\nConfigure the modules to be imported.");
        $mapping = [];
        foreach ($srcMods as $srcMod) {
            $mod = $srcMod['shortform'];
            if ($mod == 'cor') {
                continue;
            }
            $descr = $srcMod['description'];
            $this->write("\nModule $mod - $descr");
            if ($mod == 'abk') {
                $mapping['abk']['module'] = 'actor';
                $mapping['abk']['schema'] = 'core.actor';
                if (isset($destMod['actor'])) {
                    $mapping['abk']['mode'] = 'existing';
                    $mapping['abk']['config'] = $destMod['actor'];
                    // TODO Schema
                } else {
                    $mapping['abk']['mode'] = 'new';
                    $module['module'] = 'actor';
                    $module['resource'] = 'actors';
                    $module['project'] = 'ARK';
                    $module['namespace'] = 'ARK\Entity';
                    $module['entity'] = 'Actor';
                    $module['classname'] = 'ARK\Entity\Actor';
                    $module['tbl'] = 'ark_item_actor';
                    $module['core'] = true;
                    $module['keyword'] = 'module.actor';
                    $mapping['abk']['config'] = $module;
                }
                $this->write(" - Auto-mapped to Actor module");
            } else {
                $choice = $this->askChoice('Please choose a module to migrate to', $destModChoices, $skipChoice);
                if ($choice == $newChoice) {
                    // TODO repeat until not a current module
                    $module['module'] = $this->askQuestion('Please enter the new module code as a singular noun, e.g. context or image');
                    $module['resource'] = $this->askQuestion('Please enter the resource code as a plural noun, e.g. contexts or images');
                    $module['project'] = $this->askQuestion('Please enter the root namespace, e.g. ARK or MyProject', 'ARK');
                    $module['namespace'] = ucfirst($module['project']).'\\Entity';
                    $module['entity'] = ucfirst($module['module']);
                    $module['classname'] = $module['namespace'].'\\'.$module['entity'];
                    $module['tbl'] = 'ark_item_'.$module['module'];
                    $module['keyword'] = 'module.'.$module['module'];
                    $mapping[$mod]['module'] = $module['module'];
                    $mapping[$mod]['mode'] = 'new';
                    $mapping[$mod]['config'] = $module;
                    // TODO Create Schema
                    $mapping[$mod]['schema'] = $key.'.'.$module['module'];
                    unset($module);
                } elseif ($choice != $skipChoice) {
                    $mapping[$mod]['mode'] = 'existing';
                    $mapping[$mod]['module'] = $choice;
                    $mapping[$mod]['config'] = $destMod[$choice];
                    // TODO Schema
                    $schemaRows = $core->executeQuery("SELECT * FROM ark_schema WHERE module = ?", [$choice])->fetchAll();
                    $schemaChoices[] = $key.'.'.$choice;
                    foreach ($schemaRows as $schema) {
                        $schemaChoices[] = $schema['schma'];
                    }
                    $schema = $this->askChoice('Please choose a schema to use', $schemaChoices, $schemaChoices[0]);
                    $mapping[$mod]['schema'] = $schema;
                }
            }
        }

        $this->write("\nThe following modules will be migrated:");
        $table = new Table($this->output);
        $table->setHeaders(['Old', 'New', 'Schema', 'Entity', 'Table']);
        foreach ($mapping as $mod => $module) {
            $table->addRow([$mod, $module['module'], $module['schema'], $module['config']['entity'], $module['config']['tbl']]);
            //$table->addRow(new TableSeparator());
        }
        unset($module);
        $table->render();
        if (!$this->askConfirmation('Please confirm you want to use this mapping', false)) {
            return ConsoleCommand::ERROR_CODE;
        }

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
            $module['keyword'] = 'module.site';
            $core->insert('ark_module', $module);
            unset($module);
        }
        if (!$data->tableExists('ark_item_site')) {
            $data->createItemTable('site');
        }
        $sites = $source->fetchAllTable('cor_tbl_ste', []);
        foreach ($sites as $site) {
            if ($site['id'] != 'ARK') {
                $item = [
                    'item' => $site['id'],
                    'module' => 'site',
                    'schma' => 'core.site',
                    'idx' => $site['id'],
                    'label' => $site['id'],
                    'cre_by' => $site['cre_by'],
                    'cre_on' => $site['cre_on'],
                    'version' => '',
                ];
                $data->insert('ark_item_site', $item);
                $text = [
                    'module' => 'site',
                    'item' => $site['id'],
                    'attribute' => 'name',
                    'parameter' => 'en',
                    'value' => $site['id'],
                    'version' => '',
                ];
                $data->insert('ark_fragment_text', $text);
            }
        }

        // * MODULE SCHEMA * //
        foreach ($mapping as $mod => &$module) {
            if ($module['mode'] == 'new') {
                $core->insert('ark_module', $module['config']);
                if (!$data->tableExists($module['config']['tbl'])) {
                    $data->createItemTable($module['module']);
                }
            }
            $schema = $core->fetchArray('SELECT * FROM ark_schema WHERE schma = ?', [$module['schema']]);
            $type = null;
            $typeVocabulary = null;
            if (!$schema) {
                $modtypeTable = $mod.'_lut_'.$mod.'type';
                try {
                    $modtypes = $source->fetchAllTable($modtypeTable);
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
                    $vocab['keyword'] = $typeVocabulary;
                    $core->insert('ark_vocabulary', $vocab);
                    $term['concept'] = $typeVocabulary;
                    foreach ($modtypes as $modtype) {
                        $term['term'] = strtolower($modtype[$mod.'type']);
                        $term['keyword'] = $term['concept'].'.'.$term['term'];
                        $core->insert('ark_vocabulary_term', $term);
                    }
                }
                $schema['schma'] = $module['schema'];
                $schema['module'] = $module['module'];
                $schema['generator'] = 'ARK\Model\Entity\ItemSequenceGenerator';
                $schema['sequence'] = 'id';
                $schema['type'] = $type;
                $schema['type_vocabulary'] = $typeVocabulary;
                $schema['keyword'] = $module['schema'].'.schema';
                $core->insert('ark_schema', $schema);
            } else {
                $module['type'] = null;
                $module['modtype'] = null;
                $module['lut'] = null;
            }
        }
        unset($module);

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
            $items = $source->fetchAll($sql, []);
            $this->write($old_tbl.' : '.count($items)."\n");
            $updates = 0;
            foreach ($items as $item) {
                $itemkey = explode('_', $item['itemkey']);
                $parent = $itemkey[0];
                $index = $itemkey[1];
                $type = (isset($item['modtype']) ? strtolower($item['modtype']) : '');
                $newItem = [
                    'item' => $parent.'.'.$index,
                    'module' => $module['module'],
                    'schma' => $module['schema'],
                    'type' => $type,
                    'parent_module' => 'site',
                    'parent_item' => $parent,
                    'idx' => $index,
                    'label' => $item['itemkey'],
                    'cre_by' => $item['cre_by'],
                    'cre_on' => $item['cre_on'],
                    'version' => '',
                ];
                $data->insert($module['config']['tbl'], $newItem);
                $updates = $updates + 1;
            }
            $this->write($module['config']['tbl'].' : '.$updates."\n\n");
        }
        unset($module);

        // Copy fragments
        $parents = [];
        $classes = array(
            'attribute' => 'ark_fragment_string',
            'date' => 'ark_fragment_date',
            'number' => 'ark_fragment_integer',
            'txt' => 'ark_fragment_text',
        );
        $special = array(
            'action' => '',
            'file' => 'ark_item_file',
            'span' => '',
            'xmi' => 'ark_related',
        );
        foreach (array_keys($mapping) as $mod) {
            $modCodes[] = $mod.'_cd';
        }
        $admin = ARK::server($destinationConfig['data']['server']);
        $admin['dbname'] = $destinationConfig['data']['dbname'];
        $admin = $this->getConnection($admin);
        foreach ($classes as $dataclass => $new_tbl) {
            if ($new_tbl == '') {
                continue;
            }

            // Add temp chain fields
            $schema_new = $admin->getSchemaManager()->createSchema();
            $schema = clone $schema_new;
            if (!$schema->getTable($new_tbl)->hasColumn('old_id')) {
                $schema->getTable($new_tbl)->addColumn('old_id', 'integer');
            }
            if (!$schema->getTable($new_tbl)->hasColumn('old_itemkey')) {
                $schema->getTable($new_tbl)->addColumn('old_itemkey', 'string', array("length" => 50));
            }
            if (!$schema->getTable($new_tbl)->hasColumn('old_itemvalue')) {
                $schema->getTable($new_tbl)->addColumn('old_itemvalue', 'string', array("length" => 50));
            }
            $changes = $schema_new->getMigrateToSql($schema, $admin->getDatabasePlatform());
            foreach ($changes as $sql) {
                $admin->executeUpdate($sql, array());
            }

            $type = $dataclass.'type';
            $old_tbl = 'cor_tbl_'.$dataclass;
            $lut = 'cor_lut_'.$type;
            if ($dataclass == 'attribute') {
                $sql = "
                    SELECT cor_tbl_attribute.*, cor_lut_attribute.attribute, cor_lut_attributetype.attributetype
                    FROM cor_tbl_attribute, cor_lut_attribute, cor_lut_attributetype
                    WHERE cor_tbl_attribute.attribute = cor_lut_attribute.id
                    AND cor_lut_attribute.attributetype = cor_lut_attributetype.id
                ";
            } elseif ($dataclass == 'file') {
                $sql = "
                    SELECT cor_tbl_file.*, cor_lut_filetype.filetype
                    FROM cor_tbl_file, cor_lut_file, cor_lut_filetype
                    WHERE cor_tbl_file.file = cor_lut_file.id
                    AND cor_lut_file.filetype = cor_lut_filetype.id
                ";
            } elseif ($dataclass == 'xmi') {
                $sql = "
                    SELECT $old_tbl.*
                    FROM $old_tbl
                ";
            } else {
                $sql = "
                    SELECT $old_tbl.*, $lut.$type AS $type
                    FROM $old_tbl, $lut
                    WHERE $old_tbl.$type = $lut.id
                ";
            }
            $frags = $source->fetchAll($sql, array());
            $this->write($old_tbl.' : '.count($frags)."\n");
            $updates = 0;
            foreach ($frags as $frag) {
                if (!in_array($frag['itemkey'], $modCodes)) {
                    continue;
                }
                if (substr($frag['itemkey'], 0, 11) == 'cor_tbl_map') {
                    $this->write('Skipping map frag : '.$frag['id'].' : '.$frag['itemkey'].' : '.$frag['itemvalue']."\n");
                    continue;
                }
                // Skip if parent is a lut
                if (substr($frag['itemkey'], 0, 8) == 'cor_lut_') {
                    $this->write('Skipping lut frag : '.$frag['id'].' : '.$frag['itemkey'].' : '.$frag['itemvalue']."\n");
                    continue;
                }
                // If itemkey/itemvalue is a chain reference, replace with actual item
                if ($source->tableExists($frag['itemkey'])) {
                    $frag['old_itemkey'] = $frag['itemkey'];
                    $frag['old_itemvalue'] = $frag['itemvalue'];
                    $frag = array_merge($frag, $this->getParent($source, $frag['itemkey'], $frag['itemvalue']));
                }
                // Skip if parent doesn't exist, i.e. orphaned frag!
                if ($frag['itemkey'] == null) {
                    $this->write('Skipping orphan frag : '.$frag['id'].' : '.$frag['old_itemkey'].' : '.$frag['old_itemvalue']."\n");
                    continue;
                }
                if ($dataclass == 'attribute') {
                    $frag['value'] = (isset($attribute[$frag['attribute']]) ? $attribute[$frag['attribute']]: $frag['attribute']);
                    unset($frag['attribute']);
                    unset($frag['boolean']);
                }
                if (isset($frag[$type])) {
                    $frag['attribute'] = $frag[$type];
                    unset($frag[$type]);
                }
                $frag['old_id'] = $frag['id'];
                unset($frag['id']);
                unset($frag['typemod']);
                unset($frag['fragtype']);
                unset($frag['fragid']);
                if (isset($frag['itemkey'])) {
                    if ($frag['itemkey'] == 'abk_cd') {
                        $frag['module'] = 'actor';
                    } else {
                        $frag['module'] = $mapping[substr($frag['itemkey'], 0, 3)]['module'];
                    }
                }
                if (isset($frag['actor_itemkey'])) {
                    if ($frag['actor_itemkey'] == 'abk_cd') {
                        $frag['actor_module'] = 'actor';
                    } else {
                        $frag['actor_module'] = substr($frag['actor_itemkey'], 0, 3);
                    }
                    $frag['actor_item'] = $frag['actor_itemvalue'];
                    unset($frag['actor_itemkey']);
                    unset($frag['actor_itemvalue']);
                }
                if (isset($frag['xmi_itemkey'])) {
                    if ($frag['xmi_itemkey'] == 'abk_cd') {
                        $frag['xmi_module'] = 'act';
                    } else {
                        $frag['xmi_module'] = substr($frag['xmi_itemkey'], 0, 3);
                    }
                    $itemvalue = explode('_', $frag['xmi_itemvalue']);
                    $parent = $itemvalue[0];
                    if (!isset($itemvalue[1])) {
                        $this->write('Skipping XMI frag : '.$frag['old_id'].' : '.$frag['xmi_itemkey'].' : '.$frag['xmi_itemvalue']."\n");
                        continue;
                    }
                    $index = $itemkey[1];
                    $id = $parent.'.'.$index;
                    $frag['xmi_item'] = $id;
                    unset($frag['xmi_itemkey']);
                    unset($frag['xmi_itemvalue']);
                }
                $itemvalue = explode('_', $frag['itemvalue']);
                $parent = $itemvalue[0];
                $index = $itemvalue[1];
                $id = $parent.'.'.$index;
                $frag['item'] = $id;
                unset($frag['itemkey']);
                unset($frag['itemvalue']);
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
                    unset($frag['txt']);
                    unset($frag['language']);
                }
                $frag['version'] = '';
                $data->insert($new_tbl, $frag);
                $updates = $updates + 1;
            }
            $this->write($new_tbl.' : '.$updates."\n\n");
        }

        // Done!
        $data->commit();
        $core->commit();
    }

    private function getParent($conn, $tbl, $id)
    {
        $sql = "
            SELECT *
            FROM $tbl
            WHERE id = ?
        ";
        $parent = $conn->fetchAssoc($sql, [$id]);
        if ($conn->tableExists($parent['itemkey'])) {
            return $this->getParent($conn, $parent['itemkey'], $parent['itemvalue']);
        }
        return ['itemkey' => $parent['itemkey'], 'itemvalue' => $parent['itemvalue']];
    }
}
