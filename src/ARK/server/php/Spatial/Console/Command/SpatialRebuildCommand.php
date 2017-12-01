<?php

/**
 * Ark Spatial Console Command.
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

namespace ARK\Spatial\Console\Command;

use ARK\ARK;
use ARK\Database\Console\Command\DatabaseCommand;
use Doctrine\DBAL\DBALException;

class SpatialRebuildCommand extends DatabaseCommand
{
    protected function configure() : void
    {
        $this->setName('spatial:rebuild')
             ->setDescription('Rebuild the Spatial Index');
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
            $conn->truncateTable('ark_spatial_fragment');
            $conn->commit();
            $this->write('SUCCESS: Spatial index rebuilt.');
        } catch (DBALException $e) {
            $conn->rollBack();
            $this->writeException('Spatial index rebuild failed', $e);
        }
        $conn->enableForeignKeyChecks();
    }
}
