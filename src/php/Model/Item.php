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
    private $site = '';
    private $module = '';
    private $item = '';
    private $itemkey = '';
    private $itemvalue = '';
    private $subtype = null;
    protected $valid = false;

    public function __construct($site = '', $module = '', $item = '', $subtype = null)
    {
        if ($site) {
            $config['site'] = $site;
            $config['module'] = $module;
            $config['item'] = $item;
            $config['subtype'] = $subtype;
            $this->loadConfig($config);
        }
    }

    protected function loadConfig($config)
    {
        $this->site = $config['site'];
        $this->module = $config['module'];
        $this->item = $config['item'];
        $this->itemkey = $this->module.'_cd';
        $this->itemvalue = ($this->module == 'ste' ? $this->site : $this->site.'_'.$this->item);
        if (isset($config['subtype'])) {
            $this->subtype = $config['subtype'];
        }
        $this->valid = true;
    }

    public function isValid()
    {
        return $this->valid;
    }

    public function site()
    {
        return $this->site;
    }

    public function module()
    {
        return $this->module;
    }

    public function item()
    {
        return $this->item;
    }

    public function itemkey()
    {
        return $this->itemkey;
    }

    public function itemvalue()
    {
        return $this->itemvalue;
    }

    public function subtype()
    {
        return $this->subtype;
    }

    static public function get(Database $db, $site, $module, $id)
    {
        $item = new Item();
        $config = $db->getItem($site, $module, $id);
        if (!$config) {
            //throw new Error(1000);
            return $item;
        }
        $config['module'] = $module;
        $item->loadConfig($config);
        return $item;
    }

    static public function getAll(Database $db, $site, $module)
    {
        $items = array();
        $configs = $db->getItems($site, $module);
        foreach ($configs as $config) {
            $item = new Item();
            $config['module'] = $module;
            $item->loadConfig($config);
            $items[] = $item;
        }
        return $items;
    }

}
