<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Translation/ActorLoader.php
*
* Ark Alias Translation Loader
*
* PHP versions 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Partnership Ltd.
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @package    ark
* @author     John Layt <j.layt@lparchaeology.com>
* @copyright  2016 L - P : Heritage LLP.
* @license    GPL-3.0+
* @see        http://ark.lparchaeology.com/code/src/php/Translation/ActorLoader.php
* @since      2.0
*/

namespace ARK\Translation;

use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\Translation\Loader\LoaderInterface;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class ActorLoader implements LoaderInterface
{
    public function load($db, $locale, $domain = 'actors')
    {
        $catalogue = new MessageCatalogue($locale);
        $sql = "
            SELECT *
            FROM ark_module_act, ark_dataclass_string
            WHERE ark_dataclass_string.module = :module
            AND ark_dataclass_string.item = ark_module_act.id
            AND ark_dataclass_string.property = :property
        ";
        $params = array(
            ':module' => 'act',
            ':property' => 'name',
        );
        $actors = $db->data()->fetchAll($sql, $params);
        foreach ($actors as $actor) {
            $key = 'actors.'.$actor['item'].'.'.$actor['property'];
            $catalogue->set($key, $actor['value'], $domain);
        }
        return $catalogue;
    }
}
