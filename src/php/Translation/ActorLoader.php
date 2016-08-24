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
            FROM act_tbl_act, cor_tbl_txt
            WHERE cor_tbl_txt.itemkey = :itemkey
            AND cor_tbl_txt.itemvalue = act_tbl_act.act_cd
        ";
        $params = array(
            ':itemkey' => 'act_cd',
            ':txttype' => 'name',
        );
        $actors = $db->data()->fetchAll($sql, $params);
        foreach ($actors as $actor) {
            $key = $actor['itemkey'].'.'.$actor['itemvalue'].'.'.$actor['txttype'];
            $catalogue->set($key, $actor['txt'], $domain);
        }
        return $catalogue;
    }
}
