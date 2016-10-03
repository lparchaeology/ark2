<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Model/Collection.php
*
* ARK Model Item
*
* PHP version 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Heritage LLP.
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
* @see        http://ark.lparchaeology.com/code/src/php/Model/Item.php
* @since      2.0
*
*/

namespace ARK\Model;

use ARK\Database\Database;

class Collection extends AbstractResource
{
    private $index = null;

    protected function init(Database $db, Module $module, Item $parent = null, array $config)
    {
        parent::init($db, $module, $parent, $config);
        $this->id = $config['id'];
    }

    public function items()
    {
        return $this->module->items($this->parent);
    }

    public function recentItems(int $recent)
    {
        return $this->module->recentItems($this->parent, $recent);
    }

    public static function get(Database $db, Module $module, Item $parent = null, string $id)
    {
        $coll = new Collection();
        $config['id'] =  'id';
        $coll->init($db, $module, $parent, $config);
        return $coll;
    }
}
