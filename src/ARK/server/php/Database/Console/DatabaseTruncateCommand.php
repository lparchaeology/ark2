<?php

/**
 * Ark Database Console Command.
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

namespace ARK\Database\Console;

use ARK\ARK;
use Doctrine\DBAL\DBALException;

class DatabaseTruncateCommand extends DatabaseCommand
{
    protected function configure() : void
    {
        $this->setName('database:truncate')
             ->setDescription('Truncate all tables in a database');
    }

    protected function doExecute() : void
    {
        $conn = $this->chooseSiteConnection('root');
        if (!$this->confirmCommand($conn, 'All data in the database will be deleted!')) {
            return;
        }
        $conn->disableForeignKeyChecks();
        try {
            $conn->beginTransaction();
            $conn->truncateAllTables();
            $conn->commit();
            $this->write('SUCCESS: All tables truncated.');
        } catch (DBALException $e) {
            $conn->rollBack();
            $this->writeException('Truncate tables failed', $e);
        }
        $conn->enableForeignKeyChecks();
    }
}
