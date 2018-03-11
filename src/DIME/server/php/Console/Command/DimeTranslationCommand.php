<?php

/**
 * ARK Translation Add Command.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
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
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace DIME\Console\Command;

use ARK\Console\Command\AbstractCommand;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Translation\Domain;
use ARK\Translation\Keyword;
use ARK\Translation\Language;
use ARK\Translation\Message;
use ARK\Translation\Role;
use Symfony\Component\Console\Command\Command;

class DimeTranslationCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this->setName('dime:translation')
             ->setDescription('Add or Set a DIME translation.')
             ->addOptionalArgument('keyword', 'The translation keyword');
    }

    protected function doExecute() : void
    {
        $key = $this->input->getArgument('keyword');

        $keyword = Keyword::find($key);
        if ($keyword) {
            $this->write("\nTranslation keyword exists in domain ".$keyword->domain()->id());
            foreach ($keyword->messages() as $message) {
                $this->write($message->language()->code().' = '.$message->text());
            }
            $this->write('');
        } else {
            $domains = Domain::findAll();
            foreach ($domains as $domain) {
                $domainNames[] = $domain->id();
            }
            $domain = $this->askChoice("Please choose the domain (Default: 'dime'): ", $domainNames, 'dime');
            $domain = Domain::find($domain);
            $keyword = new Keyword($key, $domain);
        }

        $da = Language::find('da');
        $en = Language::find('en');

        $roles = Role::findAll();
        foreach ($roles as $role) {
            $roleNames[] = $role->id();
        }
        $role = $this->askChoice('Please choose the role', $roleNames, 'default');
        $role = Role::find($role);

        $daText = $this->askQuestion('Please enter the Danish text: ');

        $enText = $this->askQuestion('Please enter the English text: ');

        if ($daText || $enText) {
            ORM::persist($keyword);
        }

        if ($daText) {
            $daMsg = Message::find($keyword, $da, $role);
            if ($daMsg === null) {
                $daMsg = new Message($keyword, $da, $role);
            }
            $daMsg->setText($daText);
            ORM::persist($daMsg);
        }

        if ($enText) {
            $enMsg = Message::find($keyword, $en, $role);
            if ($enMsg === null) {
                $enMsg = new Message($keyword, $en, $role);
            }
            $enMsg->setText($enText);
            ORM::persist($enMsg);
        }

        if ($daText || $enText) {
            ORM::flush();
            Service::translation()->dump();
            $this->write("\nTranslations added.");
        }
    }

    protected function doInteract() : void
    {
        $this->askArgument('keyword', 'Please enter the translation keyword');
    }
}
