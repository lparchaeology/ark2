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

use ARK\ARK;

class SiteMigrateMapCommand extends SiteMigrateInfoCommand
{
    protected $sourcePath;
    protected $exportPath;
    protected $roles;
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
        '0.2m' => ['02m'],
        '0.3m' => ['03m'],
        '0.3m0.2m' => ['03m', '02m'],
        '0.2m1m' => ['02m', '1m'],
        '1m0.5m' => ['1m', '05m'],
        '1m0.3m' => ['1m', '03m'],
        '0.5m' => ['05m'],
        '0.5m0.2m' => ['05m', '02m'],
        '0.3m1m' => ['03m', '1m'],
        '0.2m0.5m' => ['02m', '05m'],
        '0.3m0.5m' => ['03m', '05m'],
        '0.5m0.2' => ['05m', '02'],
        '0.2m0.5m1m' => ['02m', '05m', '1m'],
        '0.2m0.2m' => ['02m', '02m'],
        'c.t.p.' => 'ctp',
        'n/a' => 'na',
        'rb??' => 'rbq',
        'n/a_1' => 'na_1',
        'n/a_2' => 'na_2',
    ];

    protected function configure() : void
    {
        $this->setName('site:migrate:map')
            ->setDescription('Create the migration mapping for an ARK 1 site');
    }

    protected function doExecute() : void
    {
        // Ask for source
        $migrate = $this->askChoice(
            'Do you want to migrate from a full install or just a database?',
            ['Full', 'Database'],
            'Full'
        );

        if (strtolower($migrate) === 'full') {
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
                return;
            }
        }
        $this->source = $this->getConnection($sourceConfig);
        $this->source->beginTransaction();
        $this->exportPath = ARK::varDir().'/migration/'.$this->source->getDatabase();

        $this->analyse();
        $this->export();
    }

    protected function export() : void
    {
        $this->write('Writing mapping to '.$this->exportPath);

        $source['path'] = $this->sourcePath;
        $source['database'] = $this->source->getParams();
        ARK::jsonEncodeWrite($source, $this->exportPath.'/source.json');

        $this->exportUsers();
        $this->exportActors();
        $this->exportSites();
    }

    protected function exportUsers() : void
    {
        $users = [];
        foreach ($this->users as $user) {
            $map = [];
            $map['id'] = $user['username'] ?? $user['actor'] ?? $user['user'] ?? null;
            $map['email'] = $user['email'] ?? '';
            $map['name'] = $user['name'] ?? '';
            if (in_array('ADMINS', $user['groups'], true)) {
                $map['level'] = 'ROLE_ADMIN';
                if (isset($user['actor'])) {
                    $this->roles[$user['actor']] = ['admin', 'archaeologist', 'manager', 'sysadmin'];
                }
            } elseif (in_array('SUPERVISOR', $user['groups'], true)) {
                $map['level'] = 'ROLE_USER';
                if (isset($user['actor'])) {
                    $this->roles[$user['actor']] = ['archaeologist', 'supervisor'];
                }
            } elseif (in_array('USERS', $user['groups'], true)) {
                $map['level'] = 'ROLE_USER';
                if (isset($user['actor'])) {
                    $this->roles[$user['actor']] = ['archaeologist'];
                }
            } else {
                $map['level'] = 'ROLE_USER';
                if (isset($user['actor'])) {
                    $this->roles[$user['actor']] = ['researcher'];
                }
            }
            $map['enabled'] = $user['enabled'] ?? false;
            $map['meta']['user'] = $user['user'] ?? null;
            $map['meta']['username'] = $user['username'] ?? null;
            $map['meta']['actor'] = $user['actor'] ?? null;
            $map['meta']['audit'] = $user['audit'] ?? false;
            $map['meta']['action'] = $user['action'] ?? false;
            $users['map'][$user['user']] = $map;
            $users['items'][] = $user;
        }
        ARK::jsonEncodeWrite($users, $this->exportPath.'/user.map.json');
    }

    protected function exportActors() : void
    {
        $actors = [];
        foreach ($this->actors as $actor) {
            $actors['map'][$actor['actor']]['id'] = $actor['actor'];
            if (isset($this->roles[$actor['actor']])) {
                $actors['map'][$actor['actor']]['roles'] = $this->roles[$actor['actor']];
            } else {
                $actors['map'][$actor['actor']]['roles'] = [];
            }
            $actors['map'][$actor['actor']]['meta']['name'] = $actor['name'];
            $actors['map'][$actor['actor']]['meta']['action'] = $actor['action'];
            $actors['items'][] = $actor;
        }
        ARK::jsonEncodeWrite($actors, $this->exportPath.'/actor.map.json');
    }

    protected function exportSites() : void
    {
        $sites = [];
        foreach ($this->sites as $site) {
            $map = [];
            $map['id'] = $site['items'] > 0 ? $site['id'] : false;
            $map['modules'] = [];
            foreach ($site['modules'] as $module => $count) {
                $map['modules'][$module] = ($module === 'abk' ? 'actor' : $module);
            }
            $map['meta']['name'] = $site['description'];
            $map['meta']['items'] = $site['items'];
            $sites[$site['id']] = $map;
        }
        ARK::jsonEncodeWrite($sites, $this->exportPath.'/site.map.json');
    }

    protected function modules() : iterable
    {
        $modules = [];
        foreach (ARK::namespaces() as $namespace) {
            $dir = ARK::namespaceDir($namespace).'/server/schema/module';
            if (is_dir($dir)) {
                foreach (scandir($dir) as $module) {
                    $modDir = $dir.'/'.$module;
                    if ($module !== '.' && $module !== '..' && is_dir($modDir)) {
                        $key = $namespace.':'.$module;
                        $modules[$key]['namespace'] = $namespace;
                        $modules[$key]['module'] = $module;
                        $modules[$key]['dir'] = $modDir;
                        $modules[$key]['schemas'] = [];
                        foreach (scandir($modDir) as $schema) {
                            if ($schema !== '.' && $schema !== '..' && $schema !== 'module.json') {
                                $modules[$key]['schemas'][] = explode('.', $schema)[0];
                            }
                        }
                    }
                }
            }
        }
        return $modules;
    }

    private function exportSchemaMapping() : void
    {
        // Choose mapping type
        $standard = 'Use a standard mapping for all modules.';
        $custom = 'Create a custom mapping for all modules.';
        $mappingChoices = [$standard, $custom];
        $mapping = $this->askChoice('Please choose a mapping method', $mappingChoices, $standard);

        if ($mapping === $standard) {
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
        $modules = $this->modules();
        $modlist = array_merge(['custom'], array_keys($modules));
        foreach ($this->modules as $source) {
            $mod = $source['shortform'];
            if ($mod === 'cor' || $mod === 'abk' || $mod === 'ste') {
                continue;
            }
            $descr = $source['description'];
            $this->write("\nModule $mod - $descr");

            $migrate = $this->askChoice('Please choose the module you wish to migrate to:', $modlist, 'custom');
            if ($migrate === 'custom') {
                $default = $this->$defaults[$mod] ?? null;
                $module['key'] = $migrate;
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
                if (!in_array($coreSchema, $schemaChoices, true)) {
                    $schemaChoices[] = $coreSchema;
                }
                $siteSchema = $this->siteKey.'.'.$module['module'];
                if (!in_array($siteSchema, $schemaChoices, true)) {
                    $schemaChoices[] = $siteSchema;
                }
                $schema = $this->askChoice('Please choose a schema to use', $schemaChoices, $coreSchema);
                $mapping[$mod]['schema'] = $schema;
                unset($schemas, $module, $schemaChoices, $coreSchema, $siteSchema);
            } else {
                $schemas = $modules[$migrate]['schemas'];
                if (count($schemas) > 1) {
                    $schema = $this->askChoice('Please choose the schema to use:', $schemas);
                } else {
                    $schema = $schemas[0];
                }
                $module['key'] = $migrate;
                $module['schema'] = $schema;
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
