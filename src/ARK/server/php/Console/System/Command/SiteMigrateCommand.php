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
use ARK\Database\Console\DatabaseCommand;
use Doctrine\DBAL\DBALException;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SiteMigrateCommand extends DatabaseCommand
{
    use ProcessTrait;

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
            $command = $this->getApplication()->find('site:create');
            $site = $command->run(new ArrayInput([]), $this->output);
        } else {
            $site = $this->askChoice('Please choose the site to migrate into', ARK::sites());
        }
        dump('site');
        dump($site);
        if ($site === false) {
            return false;
        }
        $destinationConfig = ARK::siteDatabaseConfig($site);

        // Clone old database and get clone connection
        $clone = $this->askChoice('Do you want to clone the database or an use an existing clone?', ['New', 'Existing'], 'New');
        if (strtolower($migrate) == 'new') {
            $command = $this->getApplication()->find('database:clone');
            $arguments = new ArrayInput([
                'site' => strtolower($site),
            ]);
            $sourceConfig = $command->run($arguments, $this->output);
        } else {
            $sourceConfig = $this->chooseServerConfig();
        }
        if (!$sourceConfig) {
            return false;
        }
        $source = $this->getConnection($sourceConfig);

        // Do any fixes?

        // Set up modules in new, loop through list asking required details, choose schema, etc, create data tables
        $newModChoice = 'Create new module';
        $skipModChoice = 'Skip module';
        $destModChoices = [$newModChoice, $skipModChoice];

        $destination = $this->getConnection($destinationConfig['core']);
        $modRows = $destination->fetchAllTable('ark_module');
        foreach ($modRows as $mod) {
            if (!$mod['core']) {
                $destModChoices[] = $mod['module'];
            }
            $destMod[$mod['module']] = $mod;
        }

        $srcMods = $source->fetchAllTable('cor_tbl_module');
        $this->write("\nConfigure the modules to be imported.");
        $mapping = [];
        foreach ($srcMods as $srcMod) {
            $mod = $srcMod['shortform'];
            $descr = $srcMod['description'];
            $this->write("\nModule $mod - $descr");
            if ($mod == 'abk') {
                $mapping['abk'] = 'actor';
                $this->write(" - Auto-mapped to Actor module");
            } else {
                $choice = $this->askChoice('Please choose a module to migrate to', $destModChoices, 0);
                if ($choice == $newModChoice) {
                    // TODO repeat until not a current module
                    $module['module'] = $this->askQuestion('Please enter the new module code as a singular noun, e.g. context or image');
                    $module['resource'] = $this->askQuestion('Please enter the resource code as a plural noun, e.g. contexts or images');
                    $module['namespace'] = $this->askQuestion('Please enter the sourcecode namespace, e.g. ARK or MyProject', 'ARK');
                    $module['entity'] = $module['namespace'].'\\Entity\\'.$module['module'];
                    $module['tbl'] = 'ark_item_'.$module['module'];
                    $module['core'] = false;
                    $module['enabled'] = true;
                    $module['deprecated'] = false;
                    $module['keyword'] = 'module.'.$module['module'];
                    // TODO Schema
                    $mapping[$mod] = $module;
                } elseif ($choice != $skipModChoice) {
                    $mapping[$mod] = $choice;
                    // TODO Schema
                }
            }
        }

        $this->write("\nThe following modules will be migrated:");
        $table = new Table($this->output);
        $table->setHeaders(['Old', 'New', 'Entity', 'Table']);
        foreach ($mapping as $mod => $module) {
            if (is_array($module)) {
                $table->addRow([$mod, $module['module'], $module['entity'], $module['table']]);
            } else {
                $table->setRows([$mod, $module, $destMod[$module]['entity'], $destMod[$module]['table']]);
            }
        }
        $table->render();
        if (!$this->askConfirmation('Please confirm you want to use this mapping', false)) {
            return false;
        }

        // Copy items
        // Copy fragments

        // Done!
    }
}
