<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Schema/Tab.php
*
* ARK Schema Tab
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
* @see        http://ark.lparchaeology.com/code/src/php/Schema/Tab.php
* @since      2.0
*
*/

namespace ARK\Schema;

use ARK\Database\Database;

class TabbedLayout extends Element
{
    private $_block = 'tablayout';
    private $_style = 'tab';
    private $_just = false;
    private $_fade = false;
    private $_tabs = array();

        function __construct(Database $db = null, $tab_id = null, $mod = null, $modtype = null)
    {
        if ($db == null || $tab_id == null) {
            return;
        }
        parent::__construct($db, $tab_id);
        if (!$this->_isTab) {
            return;
        }
        $sql = "
            SELECT *
            FROM ark_config_layout
            WHERE layout_id = :layout_id
        ";
        $config = $db->config()->fetchAssoc($sql, array(':layout_id' => $tab_id));
        $this->_template = $config['template'];
        $sql = "
            SELECT *
            FROM ark_config_layout_grid
            WHERE layout_id = :layout_id
            AND (modtype = :modtype OR modtype = :mod)
            AND enabled = :enabled
        ";
        $params = array(
            ':layout_id' => $tab_id,
            ':modtype' => $modtype,
            ':mod' => $mod,
            ':enabled' => true,
        );
        $elements = $db->config()->fetchAll($sql, $params);
        foreach ($elements as $element) {
            $this->_tabs[$element['tab']][$element['row']][$element['col']][] = new Tab($db, $element['element_id']);
        }
        $this->_valid = true;
    }

    function block()
    {
        return $this->_block;
    }

    function style()
    {
        return $this->_style;
    }

    function justified()
    {
        return $this->_just;
    }

    function fade()
    {
        return $this->_fade;
    }

    function tabs()
    {
        return $this->_tabs;
    }

}
