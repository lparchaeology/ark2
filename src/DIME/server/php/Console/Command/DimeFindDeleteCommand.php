<?php

/**
 * ARK User Command.
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

namespace DIME\Console\Command;

use ARK\Console\Command\AbstractCommand;
use ARK\ORM\ORM;
use DIME\Entity\Find;

class DimeFindDeleteCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this->setName('dime:find:delete')
             ->setDescription('Delete a find')
             ->addOptionalArgument('id', 'The find to delete');
    }

    protected function doExecute() : void
    {
        $id = $this->input->getArgument('id');
        $find = ORM::find(Find::class, $id);
        if (!$find) {
            $this->write('FAILURE: Find does not exist!');
        } elseif ($this->askConfirmName('WARNING: The find will be deleted and cannot be restored!', $id)) {
            $find->delete();
            ORM::flush();
            $this->write('SUCCESS: Find deleted');
        } else {
            $this->write('FAILURE: ID did not match, find not deleted');
        }
    }

    protected function doInteract() : void
    {
        $this->askArgument('id', 'Please enter the find id to delete');
    }
}
