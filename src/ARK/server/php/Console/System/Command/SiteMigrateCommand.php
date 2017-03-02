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
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SiteMigrateCommand extends DatabaseCommand
{
    use ProcessTrait;

    protected static $defaults = [
        'cxt' => 'context',
        'grp' => 'group',
        'pln' => 'plan',
        'rgf' => 'find',
        'sec' => 'section',
        'sgr' => 'subgroup',
        'smp' => 'sample',
        'sph' => 'photo',
        'tmb' => 'timber',
    ];
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
    protected $site = '';
    protected $siteKey = '';
    protected $source = null;
    protected $core = null;
    protected $data = null;
    protected $user = null;

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
            $this->site = strtolower($this->runCommand('site:create'));
            $this->siteKey = $this->site;
        } else {
            $this->site = strtolower($this->askChoice('Please choose the site to migrate into', ARK::sites()));
            $this->siteKey = strtolower($this->askQuestion('Please enter a unique key for the site being migrated'));
        }
        if ($this->site === ConsoleCommand::ERROR_CODE) {
            return ConsoleCommand::ERROR_CODE;
        }
        $destinationConfig = ARK::siteDatabaseConfig($this->site, true);
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
        $this->source = $this->getConnection($sourceConfig);
        $this->source->beginTransaction();

        // Do any fixes?

        // Set up modules in new, loop through list asking required details, choose schema, etc, create data tables
        $newChoice = 'Create New Module';
        $skipChoice = 'Skip This Module';
        $destModChoices = [$newChoice, $skipChoice];
        $this->core = $this->getConnection($destinationConfig['core']);
        $this->data = $this->getConnection($destinationConfig['data']);
        $this->user = $this->getConnection($destinationConfig['user']);
        $this->core->beginTransaction();
        $this->data->beginTransaction();
        $this->user->beginTransaction();
        $modRows = $this->core->fetchAllTable('ark_module');
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

        $srcMods = $this->source->fetchAllTable('cor_tbl_module');
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
                $choice = $this->askChoice('Please choose a module to migrate to', $destModChoices, $newChoice);
                if ($choice == $newChoice) {
                    // TODO repeat until not a current module
                    if (isset(self::$defaults[$mod])) {
                        $module['module'] = $this->askQuestion('Please enter the new module code as a singular noun, e.g. context or image', self::$defaults[$mod]);
                    } else {
                        $module['module'] = $this->askQuestion('Please enter the new module code as a singular noun, e.g. context or image');
                    }
                    $module['resource'] = $this->askQuestion('Please enter the resource code as a plural noun, e.g. contexts or images', $module['module'].'s');
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
                    $mapping[$mod]['schema'] = $this->siteKey.'.'.$module['module'];
                    unset($module);
                } elseif ($choice != $skipChoice) {
                    $mapping[$mod]['mode'] = 'existing';
                    $mapping[$mod]['module'] = $choice;
                    $mapping[$mod]['config'] = $destMod[$choice];
                    // TODO Schema
                    $schemaRows = $this->core->executeQuery("SELECT * FROM ark_schema WHERE module = ?", [$choice])->fetchAll();
                    $schemaChoices[] = $this->siteKey.'.'.$choice;
                    foreach ($schemaRows as $schema) {
                        $schemaChoices[] = $schema['schma'];
                    }
                    $schema = $this->askChoice('Please choose a schema to use', $schemaChoices, $schemaChoices[0]);
                    $mapping[$mod]['schema'] = $schema;
                }
            }
        }
        foreach (array_keys($mapping) as $mod) {
            $modCodes[] = $mod.'_cd';
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
            $module['keyword'] = 'module.site';
            $this->core->insert('ark_module', $module);
            unset($module);
        }
        if (!$this->data->tableExists('ark_item_site')) {
            $this->data->createItemTable('site');
        }
        $sites = $this->source->fetchAllTable('cor_tbl_ste', []);
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
                $this->data->insert('ark_item_site', $item);
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
            if ($module['mode'] == 'new') {
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
                    $vocab['keyword'] = $typeVocabulary;
                    $this->core->insert('ark_vocabulary', $vocab);
                    $term['concept'] = $typeVocabulary;
                    foreach ($modtypes as $modtype) {
                        $term['term'] = strtolower($modtype[$mod.'type']);
                        $term['keyword'] = $term['concept'].'.'.$term['term'];
                        $this->core->insert('ark_vocabulary_term', $term);
                    }
                } else {
                    $module['type'] = null;
                    $module['modtype'] = false;
                    $module['lut'] = null;
                }
                $schema['schma'] = $module['schema'];
                $schema['module'] = $module['module'];
                $schema['generator'] = 'ARK\Model\Entity\ItemSequenceGenerator';
                $schema['sequence'] = 'id';
                $schema['type'] = $type;
                $schema['type_vocabulary'] = $typeVocabulary;
                $schema['keyword'] = $module['schema'].'.schema';
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
            $this->core->insert('ark_vocabulary', $vocab);
        }
        $sql = "
            SELECT cor_lut_attribute.*, cor_lut_attributetype.attributetype
            FROM cor_lut_attribute, cor_lut_attributetype
            WHERE cor_lut_attribute.attributetype = cor_lut_attributetype.id
        ";
        $attributes = $this->source->fetchAll($sql);
        foreach ($attributes as $attribute) {
            $term['concept'] = strtolower($this->siteKey.'.'.$attribute['attributetype']);
            $term['term'] = $this->makeAttribute($attribute['attribute']);
            $term['keyword'] = $term['concept'].'.'.$term['term'];
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
            $progress = new ProgressBar($this->output, $count);
            $progress->start();
            foreach ($items as $item) {
                $progress->advance();
                $newItem = $this->makeItemKey($item['itemkey']);
                $newItem['module'] = $module['module'];
                $newItem['schma'] = $module['schema'];
                $newItem['type'] = (isset($item['modtype']) ? strtolower($item['modtype']) : '');
                $newItem['cre_by'] = $item['cre_by'];
                $newItem['cre_on'] = $item['cre_on'];
                $this->data->insert($module['config']['tbl'], $newItem);
                $updates = $updates + 1;
            }
            $progress->finish();
            $this->write("\n".$module['config']['tbl']." : $updates\n");
        }
        unset($module);

        // * COPY FILE ITEMS * /
        $sql = "
            SELECT cor_lut_file.*, cor_lut_filetype.filetype
            FROM cor_lut_file, cor_lut_filetype
            WHERE cor_lut_file.filetype = cor_lut_filetype.id
        ";
        $rows = $this->source->fetchAllTable('cor_lut_file');
        $count = count($rows);
        $this->write('cor_lut_file : '.$count);
        $progress = new ProgressBar($this->output, $count);
        $progress->start();
        $updates = 0;
        foreach ($rows as $row) {
            $progress->advance();
            $item = [
                'item' => $row['id'],
                'module' => 'file',
                'schma' => 'core.file',
                'type' => 'other',
                'idx' => $row['id'],
                'label' => $row['filename'],
                'cre_by' => $row['cre_by'],
                'cre_on' => $row['cre_on'],
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
        $progress->finish();
        $this->write("\nark_item_file : $updates\n");
        $updates = 0;
        $sql = "
            SELECT cor_tbl_file.*, cor_lut_filetype.filetype
            FROM cor_tbl_file, cor_lut_file, cor_lut_filetype
            WHERE cor_tbl_file.file = cor_lut_file.id
            AND cor_lut_file.filetype = cor_lut_filetype.id
        ";
        $rows = $this->source->fetchAll($sql, array());
        $count = count($rows);
        $this->write('cor_tbl_file : '.$count);
        $progress = new ProgressBar($this->output, $count);
        $progress->start();
        foreach ($rows as $row) {
            $progress->advance();
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
        $progress->finish();
        $this->write("\nark_fragment_item : $updates\n");

        // * COPY FRAGMENTS * //
        $parents = [];
        $classes = array(
            'action' => 'ark_fragment_item',
            'attribute' => 'ark_fragment_string',
            'date' => 'ark_fragment_date',
            'number' => 'ark_fragment_integer',
            'txt' => 'ark_fragment_text',
        );
        $special = array(
            'xmi' => 'ark_related',
        );
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
            if (!$schema->getTable($new_tbl)->hasColumn('old_table')) {
                $schema->getTable($new_tbl)->addColumn('old_table', 'string', ["length" => 50, 'notnull' => false]);
            }
            if (!$schema->getTable($new_tbl)->hasColumn('old_id')) {
                $schema->getTable($new_tbl)->addColumn('old_id', 'integer', ['notnull' => false]);
            }
            if (!$schema->getTable($new_tbl)->hasColumn('old_parent_table')) {
                $schema->getTable($new_tbl)->addColumn('old_parent_table', 'string', ["length" => 50, 'notnull' => false]);
            }
            if (!$schema->getTable($new_tbl)->hasColumn('old_parent_id')) {
                $schema->getTable($new_tbl)->addColumn('old_parent_id', 'integer', ['notnull' => false]);
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
            } elseif ($dataclass == 'action') {
                $sql = "
                    SELECT cor_tbl_action.*, cor_lut_actiontype.actiontype
                    FROM cor_tbl_action, cor_lut_actiontype
                    WHERE cor_tbl_action.actiontype = cor_lut_actiontype.id
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
            $frags = $this->source->fetchAll($sql, array());
            $count = count($frags);
            $this->write($old_tbl.' : '.$count);
            $updates = 0;
            $progress = new ProgressBar($this->output, $count);
            $progress->start();
            foreach ($frags as $frag) {
                $progress->advance();
                if (substr($frag['itemkey'], 0, 11) == 'cor_tbl_map') {
                    $progress->clear();
                    $this->write('Skipping map frag : '.$frag['id'].' : '.$frag['itemkey'].' : '.$frag['itemvalue']);
                    $progress->display();
                    continue;
                }
                // Skip if parent is a lut
                if (substr($frag['itemkey'], 0, 8) == 'cor_lut_') {
                    $progress->clear();
                    $this->write('Skipping lut frag : '.$frag['id'].' : '.$frag['itemkey'].' : '.$frag['itemvalue']);
                    $progress->display();
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
                    $progress->clear();
                    $this->write('Skipping orphan frag : '.$frag['id'].' : '.$frag['old_parent_table'].' : '.$frag['old_parent_id']);
                    $progress->display();
                    continue;
                }
                if (!in_array($frag['itemkey'], $modCodes)) {
                    //$this->write('Skipping frag for invalid mod_cd : '.$frag['itemkey']);
                    continue;
                }
                $module = $mapping[substr($frag['itemkey'], 0, 3)]['module'];
                if ($dataclass == 'attribute') {
                    $frag['parameter'] = $this->siteKey.'.'.$frag['attributetype'];
                    $frag['value'] = $this->makeAttribute($frag['attribute']);
                    unset($frag['attribute']);
                    unset($frag['boolean']);
                }
                if (isset($frag[$type])) {
                    $frag['attribute'] = $frag[$type];
                    unset($frag[$type]);
                }
                $frag['old_table'] = $old_tbl;
                $frag['old_id'] = $frag['id'];
                unset($frag['id']);
                unset($frag['typemod']);
                unset($frag['fragtype']);
                unset($frag['fragid']);
                if (isset($frag['itemkey'])) {
                    $frag['module'] = $module;
                }
                if (isset($frag['actor_itemkey'])) {
                    $frag['parameter'] = $mapping[substr($frag['actor_itemkey'], 0, 3)]['module'];
                    $key = $this->makeItemKey($frag['actor_itemvalue']);
                    $frag['value'] = $key['item'];
                    unset($frag['actor_itemkey']);
                    unset($frag['actor_itemvalue']);
                }
                if (isset($frag['xmi_itemkey'])) {
                    $frag['xmi_module'] = $mapping[substr($frag['xmi_itemkey'], 0, 3)]['module'];
                    $key = $this->makeItemKey($frag['xmi_itemvalue']);
                    if (!isset($key['parent_module'])) {
                        $progress->clear();
                        $this->write('Skipping XMI frag : '.$frag['old_id'].' : '.$frag['xmi_itemkey'].' : '.$frag['xmi_itemvalue']);
                        $progress->display();
                        continue;
                    }
                    $frag['xmi_item'] = $key['item'];
                    unset($frag['xmi_itemkey']);
                    unset($frag['xmi_itemvalue']);
                }
                $key = $this->makeItemKey($frag['itemvalue']);
                $frag['item'] = $key['item'];
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
                $this->data->insert($new_tbl, $frag);
                $updates = $updates + 1;
            }
            $progress->finish();
            $this->write("\n$new_tbl : $updates\n");
        }

        // * COPY SPANS * //
        // TODO Other span types than tvector/sameas
        // TODO Chains?
        $updates = 0;
        $sql = "
            SELECT cor_tbl_span.*, cor_lut_spantype.spantype
            FROM cor_tbl_span, cor_lut_spantype
            WHERE cor_tbl_span.spantype = cor_lut_spantype.id
        ";
        $rows = $this->source->fetchAll($sql, array());
        $count = count($rows);
        $this->write('cor_tbl_span : '.$count);
        $progress = new ProgressBar($this->output, $count);
        $progress->start();
        foreach ($rows as $row) {
            $progress->advance();
            if (!in_array($row['itemkey'], $modCodes)) {
                continue;
            }
            $module = $mapping[substr($row['itemkey'], 0, 3)]['module'];
            $key = $this->makeItemKey($row['itemvalue']);
            $item = $key['item'];
            $key = $this->makeItemKey($row['beg']);
            $value = $key['item'];
            $key = $this->makeItemKey($row['end']);
            $span = $key['item'];
            $frag = [
                'module' => $module,
                'item' => $item,
                'attribute' => $row['spantype'],
                'parameter' => $module,
                'value' => $value,
                'span' => $span,
            ];
            $this->data->insert('ark_fragment_item', $frag);
            $updates = $updates + 1;
        }
        $progress->finish();
        $this->write("\nark_fragment_item : $updates\n");

        // Commit now so available for chaining
        $this->data->commit();
        $this->core->commit();
        $this->user->commit();

        // * CHAIN, CHAIN, CHAIN, CHAIN 'O FOOLS * //
        $fragmentTables = [
            'ark_fragment_date',
            'ark_fragment_integer',
            'ark_fragment_item',
            'ark_fragment_string',
            'ark_fragment_text',
        ];
        $dataclass_tables = array(
            'cor_tbl_action' => 'ark_fragment_item',
            'cor_tbl_attribute' => 'ark_fragment_string',
            'cor_tbl_date' => 'ark_fragment_date',
            //'cor_tbl_file' => 'cor_tbl_file',
            'cor_tbl_number' => 'ark_fragment_integer',
            //'cor_tbl_span' => 'cor_tbl_span',
            'cor_tbl_txt' => 'ark_fragment_text',
            //'cor_tbl_xmi' => 'ark_fragment_xmi',
        );
        // Add temp chain fields
        $schema_new = $admin->getSchemaManager()->createSchema();
        $schema = clone $schema_new;
        if (!$schema->getTable('ark_fragment_object')->hasColumn('old_table')) {
            $schema->getTable('ark_fragment_object')->addColumn('old_table', 'string', ["length" => 50, 'notnull' => false]);
        }
        if (!$schema->getTable('ark_fragment_object')->hasColumn('old_id')) {
            $schema->getTable('ark_fragment_object')->addColumn('old_id', 'integer', ['notnull' => false]);
        }
        $this->data->beginTransaction();
        foreach ($fragmentTables as $fragmentTable) {
            $sql = "
                SELECT *
                FROM $fragmentTable
                WHERE NULLIF(old_parent_table, '') IS NOT NULL
            ";
            $frags = $this->data->fetchAll($sql);
            $objects = [];
            foreach ($frags as $frag) {
                if ($frag['old_parent_table'] && $frag['old_parent_id']) {
                    $objects[$frag['old_parent_table']][$frag['old_parent_id']] = true;
                }
            }
        }
        foreach ($objects as $old_parent_table => $parents) {
            $fragTable = $dataclass_tables[$old_parent_table];
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
                unset($object['fid']);
                $object['attribute'] = $object['attribute'].'_obj';
                $object['datatype'] = 'object';
                unset($object['format']);
                unset($object['parameter']);
                $object['value'] = '';
                unset($object['old_parent_table']);
                unset($object['old_parent_id']);
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
                    SET object_fid = :fid
                    WHERE old_parent_table = :old_table
                    AND old_parent_id = :old_id
                ";
                $params = [
                    ':fid' => $object['fid'],
                    ':old_table' => $object['old_table'],
                    ':old_id' => $object['old_id'],
                ];
                $this->data->executeUpdate($upd, []);
            }
        }
        $this->data->commit();
        $this->write("\n$new_tbl : chained : $updates\n");

        // * DONE! * //
        $this->write("\nMigration Complete!");
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
        if ($conn->tableExists($parent['itemkey'])) {
            return $this->getParent($conn, $parent['itemkey'], $parent['itemvalue']);
        }
        return ['itemkey' => $parent['itemkey'], 'itemvalue' => $parent['itemvalue']];
    }
}
