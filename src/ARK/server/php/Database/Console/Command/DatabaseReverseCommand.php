<?php

/**
 * Ark Reverse Engineer Database Console Command.
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

namespace ARK\Database\Console\Command;

use ARK\ARK;
use Doctrine\DBAL\DBALException;

class DatabaseReverseCommand extends DatabaseCommand
{
    protected function configure() : void
    {
        $this->setName('database:reverse')
             ->setDescription('Reverse engineer an existing database as DoctrineXML');
    }

    protected function doExecute() : void
    {
        $site = $this->askChoice('Please choose the site to reverse engineer', ARK::sites());
        $config = $this->chooseServerConfig();
        $dbprefix = $site.'_ark_';
        $this->reverse($dbprefix, 'core', $config);
        $this->reverse($dbprefix, 'data', $config);
        $this->reverse($dbprefix, 'spatial', $config);
        $this->reverse($dbprefix, 'user', $config);
    }

    private function reverse(string $prefix, string $name, iterable $config) : void
    {
        // Get the Admin Connection
        $dbname = $prefix.$name;
        $config['dbname'] = $dbname;
        $admin = $this->getConnection($config);

        $path = ARK::namespaceDir('ARK')."/server/schema/database/$name.xml";
        try {
            $admin->extractSchema($path, true);
        } catch (DBALException $e) {
            $this->writeException("FAILED: Extract Schema from database $dbname failed", $e);
            return;
        }

        $admin->close();
        $this->write("SUCCESS: Schema for $dbname extracted to file $path");
    }
}