<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Layout/Table.php
*
* ARK Layout Table
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
* @see        http://ark.lparchaeology.com/code/src/php/Layout/Table.php
* @since      2.0
*
*/

namespace ARK\Layout;

use ARK\Database\Database;
use Symfony\Component\Form\FormFactoryInterface;

class Table extends Layout
{
    function __construct(Database $db = null, $layout_id = null, $modname = null, $modtype = null)
    {
        if ($db == null || $layout_id == null) {
            return;
        }
        parent::__construct($db, $layout_id, $modname, $modtype);
        $this->_template = 'layouts/table.html.twig';
    }

    function header()
    {
        return $this->optionValue('header', true);
    }

    function footer()
    {
        return $this->optionValue('footer', false);
    }

    function striped()
    {
        return $this->optionValue('striped', false);
    }

    function bordered()
    {
        return $this->optionValue('bordered', false);
    }

    function hover()
    {
        return $this->optionValue('hover', true);
    }

    function condensed()
    {
        return $this->optionValue('condensed', false);
    }

    function responsive()
    {
        return $this->optionValue('responsive', true);
    }

    function pagination()
    {
        return $this->optionValue('pagination', true);
    }

    function search()
    {
        return $this->optionValue('search', true);
    }

    function export()
    {
        return $this->optionValue('export', true);
    }

    function fields()
    {
        return $this->elements();
    }

}
