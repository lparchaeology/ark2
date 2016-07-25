<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Schema/TableLayout.php
*
* ARK Schema TableLayout
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
* @see        http://ark.lparchaeology.com/code/src/php/Schema/TableLayout.php
* @since      2.0
*
*/

namespace ARK\Schema;

use ARK\Database\Database;
use Symfony\Component\Form\FormFactoryInterface;

class TableLayout extends Layout
{
    function __construct(Database $db = null, $layout_id = null, $modname = null, $modtype = null)
    {
        if ($db == null || $layout_id == null) {
            return;
        }
        parent::__construct($db, $layout_id, $modname, $modtype);
        $this->_template = 'tablelayout.html.twig';
    }

    function striped()
    {
        if (isset($this->_options['striped'])) {
            return $this->_options['striped'];
        } else {
            return false;
        }
    }

    function bordered()
    {
        if (isset($this->_options['bordered'])) {
            return $this->_options['bordered'];
        } else {
            return false;
        }
    }

    function hover()
    {
        if (isset($this->_options['hover'])) {
            return $this->_options['hover'];
        } else {
            return false;
        }
    }

    function condensed()
    {
        if (isset($this->_options['condensed'])) {
            return $this->_options['condensed'];
        } else {
            return false;
        }
    }

    function responsive()
    {
        if (isset($this->_options['responsive'])) {
            return $this->_options['responsive'];
        } else {
            return false;
        }
    }

}
