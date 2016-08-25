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
    private $_site = '';
    private $_module = '';
    private $_id = '';
    private $_itemkey = '';
    private $_itemvalue = '';
    private $_modtype = '';
    protected $_valid = false;

    public function __construct(Database $db, $site, $module, $item)
    {
        $this->_site = $site;
        $this->_module = $module;
        $this->_id = $item;
        $this->_itemkey = $this->_module.'_cd';
        $this->_itemvalue = $this->_site.'_'.$this->_id;
        $data = $db->getItem($this->_itemkey, $this->_itemvalue);
        if ($data) {
            if (isset($data['modtype'])) {
                $this->_modtype = $data['modtype'];
            }
            $this->_valid = true;
        }
    }

    public function site()
    {
        return $this->_site;
    }

    public function module()
    {
        return $this->_module;
    }

    public function id()
    {
        return $this->_id;
    }

    public function itemkey()
    {
        return $this->_itemkey;
    }

    public function itemvalue()
    {
        return $this->_itemvalue;
    }

    public function modtype()
    {
        return $this->_modtype;
    }

    public function valid()
    {
        return $this->_valid;
    }

}
