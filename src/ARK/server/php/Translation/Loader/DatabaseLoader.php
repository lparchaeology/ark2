<?php

/**
 * Ark Database Translation Loader.
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

namespace ARK\Translation\Loader;

use ARK\Database\Database;
use Symfony\Component\Translation\Loader\LoaderInterface;
use Symfony\Component\Translation\MessageCatalogue;

class DatabaseLoader implements LoaderInterface
{
    public function load($db, $locale, $domain = 'messages') : MessageCatalogue
    {
        $catalogue = new MessageCatalogue($locale);
        $rows = $db->getTranslationMessages($locale, $domain === 'messages' ? null : $domain);
        foreach ($rows as $row) {
            $id = $row['keyword'].'.'.$row['role'];
            if ($row['domain'] === 'validators') {
                $catalogue->set($id, $row['text'], 'validators');
            } else {
                $catalogue->set($id, $row['text'], 'messages');
            }
        }
        return $catalogue;
    }
}
