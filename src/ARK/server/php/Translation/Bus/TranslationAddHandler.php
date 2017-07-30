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

namespace ARK\Translation\Bus;

use ARK\ORM\ORM;
use ARK\Service;
use ARK\Translation\Domain;
use ARK\Translation\Language;
use ARK\Translation\Message;
use ARK\Translation\Parameter;
use ARK\Translation\Role;
use ARK\Translation\Translation;

class TranslationAddHandler
{
    public function __invoke(TranslationAddMessage $msg) : void
    {
        // Validate / Defaults
        $domain = ORM::find(Domain::class, $msg->domain() ?: 'core');
        if (!$domain) {
            // TODO Proper error
            throw new \Exception();
        }
        $role = ORM::find(Role::class, $msg->role() ?: 'default');
        if (!$role) {
            // TODO Proper error
            throw new \Exception();
        }
        $language = ORM::find(Language::class, $msg->language() ?: Service::locale());
        if (!$language || !$language->usedForMarkup()) {
            // TODO Proper error
            throw new \Exception();
        }

        // Create
        $message = null;
        $translation = ORM::find(Translation::class, $msg->keyword());
        if ($translation) {
            $message = ORM::findBy(Message::class, ['language' => $language->code(), 'key' => $translation->keyword(), 'role' => $role->name()]);
        } else {
            $translation = new Translation($msg->keyword(), $domain);
            $translation->setPlural($msg->plural());
            $parameters = [];
            foreach ($msg->parameters() as $parameter) {
                $parameters[] = new Parameter($translation, $parameter);
            }
            $translation->setParameters($parameters);
        }

        if (!$message) {
            $message = new Message($translation, $language, $role);
        }
        $message->setText($msg->text());
        $message->setNotes($msg->notes());
        $translation->addMessage($message);

        ORM::persist($translation);
        ORM::flush($translation);
    }
}
