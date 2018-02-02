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
use ARK\Workflow\Action;
use ARK\Workflow\Role;
use DIME\DIME;
use DIME\Entity\Find;

class DimeFindPublishCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this->setName('dime:find:publish')
             ->setDescription('Publish individual find, or all finds past publish date')
             ->addOptionalArgument('id', 'The specificfind to publish');
    }

    protected function doExecute() : void
    {
        $this->write('');
        $actor = Role::find('admin')->actors()->first();
        $action = Action::find('dime.find', 'publish');
        $id = $this->input->getArgument('id');
        if ($id) {
            // Publish just this find
            $find = ORM::find(Find::class, $id);
            if (!$find) {
                $this->write('FAILURE: Find does not exist!');
            } elseif ($this->askConfirmName('WARNING: The find will be published!', $id)) {
                $action->apply($actor, $find);
                ORM::flush();
                $this->write('SUCCESS: Find published');
            } else {
                $this->write('FAILURE: ID did not match, find not published');
            }
        } else {
            // Check all withheld finds
            $published = DIME::publishFinds($actor);
            if ($published) {
                foreach ($published as $id => $date) {
                    $this->write('Published Find: '.$id.', was due '.$date);
                }
            } else {
                $this->write('No finds to publish');
            }
        }
        $this->write('');
    }
}
