<?php

/**
 * ARK Translation Add Command.
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

use ARK\Framework\Console\Command\AbstractCommand;
use ARK\ORM\ORM;
use ARK\Translation\Domain;
use ARK\Translation\Language;
use ARK\Translation\Message;
use ARK\Translation\Role;
use ARK\Translation\Translation;
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
        $keyword = $this->input->getArgument('keyword');

        $key = ORM::find(Translation::class, $keyword);
        if ($key) {
            $this->write("\nTranslation keyword exists in domain ".$key->domain()->name());
            $messages = ORM::findBy(Message::class, ['keyword' => $keyword]);
            foreach ($messages as $message) {
                $this->write($message->language()->code().' = '.$message->text());
            }
            $this->write('');
        } else {
            $domain = ORM::find(Domain::class, 'dime');
            $key = new Translation($keyword, $domain);
        }

        $da = ORM::find(Language::class, 'da');
        $en = ORM::find(Language::class, 'en');

        $roles = ORM::findAll(Role::class);
        foreach ($roles as $role) {
            $roleNames[] = $role->name();
        }
        $role = $this->askChoice('Please choose the role', $roleNames, 'default');
        $role = ORM::findOneBy(Role::class, ['name' => $role]);

        $daText = $question->askQuestion('Please enter the Danish text: ');

        $enText = $question->ask('Please enter the English text: ');

        if ($daText || $enText) {
            ORM::persist($key);
        }

        if ($daText) {
            $daMsg = ORM::findOneBy(Message::class, ['language' => 'da', 'keyword' => $keyword, 'role' => $role->name()]);
            if (!$daMsg) {
                $daMsg = new Message($key, $da, $role);
            }
            $daMsg->setText($daText);
            ORM::persist($daMsg);
        }

        if ($enText) {
            $enMsg = ORM::findOneBy(Message::class, ['language' => 'en', 'keyword' => $keyword, 'role' => $role->name()]);
            if (!$enMsg) {
                $enMsg = new Message($key, $en, $role);
            }
            $enMsg->setText($enText);
            ORM::persist($enMsg);
        }

        if ($daText || $enText) {
            ORM::manager('core')->flush();
            $this->write("\nTranslations added.");
        }
    }

    protected function doInteract() : void
    {
        $this->askArgument('keyword', 'Please enter the translation keyword');
    }
}
