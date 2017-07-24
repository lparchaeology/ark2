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

namespace ARK\Site\Console;

use ARK\ARK;
use ARK\Database\Console\DatabaseCommand;
use ARK\Site\Console\SiteMigrateInfoCommand;

class SiteMigrateMapCommand extends SiteMigrateInfoCommand
{
    protected $sourcePath = null;
    protected $exportPath = null;
    protected $defaults = [
        'cxt' => [
            'module' => 'context',
            'resource' => 'contexts',
            'project' => 'ARK',
            'namespace' => 'ARK\Entity',
        ],
        'grp' => [
            'module' => 'group',
            'resource' => 'groups',
            'project' => 'ARK',
            'namespace' => 'ARK\Entity',
        ],
        'lus' => [
            'module' => 'landuse',
            'resource' => 'landuses',
            'project' => 'ARK',
            'namespace' => 'ARK\Entity',
        ],
        'pln' => [
            'module' => 'plan',
            'resource' => 'plans',
            'project' => 'ARK',
            'namespace' => 'ARK\Entity',
        ],
        'rgf' => [
            'module' => 'find',
            'resource' => 'finds',
            'project' => 'ARK',
            'namespace' => 'ARK\Entity',
        ],
        'sec' => [
            'module' => 'section',
            'resource' => 'sections',
            'project' => 'ARK',
            'namespace' => 'ARK\Entity',
        ],
        'sgr' => [
            'module' => 'subgroup',
            'resource' => 'subgroups',
            'project' => 'ARK',
            'namespace' => 'ARK\Entity',
        ],
        'smp' => [
            'module' => 'sample',
            'resource' => 'samples',
            'project' => 'ARK',
            'namespace' => 'ARK\Entity',
        ],
        'spf' => [
            'module' => 'sfind',
            'resource' => 'sfinds',
            'project' => 'ARK',
            'namespace' => 'ARK\Entity',
        ],
        'sph' => [
            'module' => 'photo',
            'resource' => 'photos',
            'project' => 'ARK',
            'namespace' => 'ARK\Entity',
        ],
        'tmb' => [
            'module' => 'timber',
            'resource' => 'timbers',
            'project' => 'ARK',
            'namespace' => 'ARK\Entity',
        ],
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

    protected function configure()
    {
        $this->setName('site:migrate:map')
            ->setDescription('Create the migration mapping for an ARK 1 site');
    }

    protected function doExecute()
    {
        // Ask for source
        $migrate = $this->askChoice(
            'Do you want to migrate from a full install or just a database?',
            ['Full', 'Database'],
            'Full'
        );

        if (strtolower($migrate) == 'full') {
            $this->sourcePath = $this->askFilePath('Please choose the old ARK install folder.');
            include $this->sourcePath.'/config/env_settings.php';
            $sourceConfig['server'] = 'mysql';
            $sourceConfig['driver'] = 'pdo_mysql';
            $sourceConfig['host'] = $sql_server;
            $sourceConfig['dbname'] = $ark_db;
            $sourceConfig['user'] = $sql_user;
            $sourceConfig['password'] = $sql_pwd;
        } else {
            $sourceConfig = $this->chooseDatabaseConfig();
            if (!is_array($sourceConfig)) {
                return $this->errorCode();
            }
        }
        $this->source = $this->getConnection($sourceConfig);
        $this->source->beginTransaction();
        $this->exportPath = ARK::varDir().'/migration/'.$this->source->getDatabase();
        $this->analyse();
        $this->export();
    }

    private function export()
    {
        $this->write('Writing mapping to '.$this->exportPath);

        $source['path'] = $this->sourcePath;
        $source['database'] = $this->source->getParams();
        ARK::jsonEncodeWrite($source, $this->exportPath.'/source.map.json');

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

        $sites = [];
        foreach ($this->sites as $site) {
            $map = [];
            $map['site'] = $site['id'];
            $map['map'] = ($site['items'] > 0);
            $sites[] = $map;
        }
        ARK::jsonEncodeWrite($sites, $this->exportPath.'/sites.map.json');
    }

    private function exportSchemaMapping()
    {
        // Choose mapping type
        $standard = 'Use a standard mapping for all modules.';
        $custom = 'Create a custom mapping for all modules.';
        $mappingChoices = [$standard, $custom];
        $mapping = $this->askChoice('Please choose a mapping method', $mappingChoices, $standard);

        if ($mapping == $standard) {
            $mapDir = ARK::namespaceDir('ARK').'/schema/migration';
            $maps = ARK::fileList($mapDir);
            $file = $this->askChoice('Please choose a standard mapping to use', $maps);
            $map['map'] = true;
            $map['type'] = 'standard';
            $map['mapping'] = $file;
            ARK::jsonEncodeWrite($sites, $this->exportPath.'/schema.map.json');
            return;
        }

        $instance = strtolower($this->askQuestion('Please enter a default instance name for the schema', 'core'));

        // ACTOR MODULE
        $module['module'] = 'actor';
        $module['schema'] = 'core.actor';
        $module['resource'] = 'actors';
        $module['project'] = 'ARK';
        $module['namespace'] = 'ARK\Actor';
        $module['entity'] = 'Site';
        $module['classname'] = 'ARK\Actor\Actor';
        $module['tbl'] = 'ark_item_site';
        $module['core'] = true;
        $module['keyword'] = 'core.module.actor';
        $modules['abk'] = $module;
        unset($module);

        // SITE MODULE
        if ($this->sites) {
            $module['module'] = 'site';
            $module['schema'] = 'core.site';
            $module['resource'] = 'sites';
            $module['project'] = 'ARK';
            $module['namespace'] = 'ARK\Entity';
            $module['entity'] = 'Site';
            $module['classname'] = 'ARK\Entity\Site';
            $module['tbl'] = 'ark_item_site';
            $module['core'] = true;
            $module['keyword'] = 'core.module.site';
            $modules['site'] = $module;
            unset($module);
        }

        $this->write("\nConfigure the modules mapping.");
        $mapping = [];
        foreach ($this->modules as $source) {
            $mod = $source['shortform'];
            if ($mod == 'cor') {
                continue;
            }
            $descr = $source['description'];
            $this->write("\nModule $mod - $descr");
            if ($mod == 'abk') {
                $this->write(' - Auto-mapped to Actor module');
            } else {
                $default = $this->$defaults[$mod] ?? null;
                $module['module'] = $this->askQuestion('Please enter the new module code as a singular noun, e.g. context or image', $default['module'] ?? null);
                $module['resource'] = $this->askQuestion('Please enter the resource code as a plural noun, e.g. contexts or images', $default['resource'] ?? $module['module'].'s');
                $module['project'] = $this->askQuestion('Please enter the root namespace, e.g. ARK or MyProject', $default['project'] ?? 'ARK');
                $module['namespace'] = ucfirst($module['project']).'\\Entity';
                $module['entity'] = ucfirst($module['module']);
                $module['classname'] = $module['namespace'].'\\'.$module['entity'];
                $module['tbl'] = 'ark_item_'.$module['module'];
                $module['keyword'] = $instance.'.module.'.$module['module'];
                $mapping[$mod]['module'] = $module['module'];
                $mapping[$mod]['mode'] = 'new';
                $mapping[$mod]['config'] = $module;

                $schemaChoices = [];
                if (isset($destSchema[$module['module']])) {
                    $schemaChoices = $destSchema[$module['module']];
                }
                $coreSchema = 'core.'.$module['module'];
                if (!in_array($coreSchema, $schemaChoices)) {
                    $schemaChoices[] = $coreSchema;
                }
                $siteSchema = $this->siteKey.'.'.$module['module'];
                if (!in_array($siteSchema, $schemaChoices)) {
                    $schemaChoices[] = $siteSchema;
                }
                $schema = $this->askChoice('Please choose a schema to use', $schemaChoices, $coreSchema);
                $mapping[$mod]['schema'] = $schema;
                unset($schemas, $module, $schemaChoices, $coreSchema, $siteSchema);
            }
        }
        foreach (array_keys($mapping) as $mod) {
            $modCodes[] = $mod.'_cd';
        }

        $this->write("\nThe following modules have been mapped:");
        $headers = ['Old', 'New', 'Schema', 'Entity', 'Table'];
        $rows = [];
        foreach ($mapping as $mod => $module) {
            $rows[] = [$mod, $module['module'], $module['schema'], $module['config']['entity'], $module['config']['tbl']];
        }
        unset($module);
        $this->writeTable($headers, $rows);
    }
}
