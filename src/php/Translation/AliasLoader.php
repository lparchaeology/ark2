<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Translation/AliasLoader.php
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
* @see        http://ark.lparchaeology.com/code/src/php/Translation/AliasLoader.php
* @since      2.0
*/

namespace ARK\Translation;

use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\Translation\Loader\LoaderInterface;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class AliasLoader implements LoaderInterface
{
    public function load($db, $locale, $domain = 'aliases')
    {
        $catalogue = new MessageCatalogue($locale);
        $sql = "
            SELECT *
            FROM cor_lut_aliastype
        ";
        $rows = $db->data()->fetchAll($sql, array());
        foreach ($rows as $row) {
            $aliastype[$row['id']] = $row['aliastype'];
        }
        $sql = "
            SELECT *
            FROM cor_tbl_alias
            WHERE language = :locale
        ";
        $params = array(
            ':locale' => $locale,
        );
        $aliases = $db->data()->fetchAll($sql, $params);
        foreach ($aliases as $alias) {
            $tbl = $alias['itemkey'];
            if ($tbl == 'cor_lut_attribute') {
                $sql = "
                    SELECT *
                    FROM cor_lut_attribute, cor_lut_attributetype
                    WHERE cor_lut_attribute.id = :id
                    AND cor_lut_attribute.attributetype = cor_lut_attributetype.id
                ";
            } else {
                $sql = "
                    SELECT *
                    FROM $tbl
                    WHERE id = :id
                ";
            }
            $params = array(
                ':id' => $alias['itemvalue'],
            );
            $source = $db->data()->fetchAssoc($sql, $params);
            if ($alias['itemkey'] == 'cor_tbl_col') {
                $src_key = 'dbname';
            } else if ($alias['itemkey'] == 'cor_tbl_module') {
                $src_key = 'itemkey';
            } else if ($alias['itemkey'] == 'cor_tbl_map') {
                $src_key = 'ste_cd';
            } else {
                $src_key = substr($alias['itemkey'], 8);
            }
            if ($tbl == 'cor_lut_attribute') {
                $key = $src_key.'.'.$source['attributetype'].'.'.$source[$src_key].'.'.$aliastype[$alias['aliastype']];
            } else {
                $key = $src_key.'.'.$source[$src_key].'.'.$aliastype[$alias['aliastype']];
            }
            $catalogue->set($key, $alias['alias'], $domain);
        }
        return $catalogue;
    }
}
