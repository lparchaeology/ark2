<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Model/Item.php
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

class Item
{
    private $module = null;
    private $item = null;
    private $index = null;
    private $modtype = '';
    protected $valid = false;

    public function __construct($module = null, $item = null, $modtype = null)
    {
        if ($module) {
            $config['module'] = $module;
            $config['item'] = $item;
            $config['modtype'] = $modtype;
            $this->loadConfig($config);
        }
    }

    protected function loadConfig($config)
    {
        $this->module = $config['module'];
        $this->item = $config['item'];
        $this->index = substr($this->item, strrpos($this->item, '.') + 1);
        if (isset($config['modtype'])) {
            $this->modtype = $config['modtype'];
        }
        $this->valid = true;
    }

    public function isValid()
    {
        return $this->valid;
    }

    public function module()
    {
        return $this->module;
    }

    public function item()
    {
        return $this->item;
    }

    public function index()
    {
        return $this->index;
    }

    public function modtype()
    {
        return $this->modtype;
    }

    static public function get(Database $db, $module, $item, $table = null)
    {
        $itm = new Item();
        $config = $db->getItem($module, $item, $table);
        if (!$config) {
            //throw new Error(1000);
            return $itm;
        }
        $config['module'] = $module;
        $itm->loadConfig($config);
        return $itm;
    }

    static public function getAll(Database $db, $module, $parent = null, $table = null)
    {
        $items = array();
        $configs = $db->getItems($module, $parent);
        foreach ($configs as $config) {
            $item = new Item();
            $config['module'] = $module;
            $item->loadConfig($config);
            $items[] = $item;
        }
        return $items;
    }

}
