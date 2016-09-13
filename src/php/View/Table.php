<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/View/Table.php
*
* ARK View Table
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
* @see        http://ark.lparchaeology.com/code/src/php/View/Table.php
* @since      2.0
*
*/

namespace ARK\View;

use Symfony\Component\Form\FormFactoryInterface;
use ARK\Database\Database;
use ARK\Model\Module;

class Table extends Layout
{
    public function __construct(Database $db = null, string $layout = null, Module $module = null, string $modtype = null)
    {
        if ($db == null || $layout == null) {
            return;
        }
        parent::__construct($db, $layout, $module, $modtype);
        $this->template = 'layouts/table.html.twig';
    }

    public function header()
    {
        return $this->optionValue('header', true);
    }

    public function footer()
    {
        return $this->optionValue('footer', false);
    }

    public function striped()
    {
        return $this->optionValue('striped', false);
    }

    public function bordered()
    {
        return $this->optionValue('bordered', false);
    }

    public function hover()
    {
        return $this->optionValue('hover', true);
    }

    public function condensed()
    {
        return $this->optionValue('condensed', false);
    }

    public function responsive()
    {
        return $this->optionValue('responsive', true);
    }

    public function pagination()
    {
        return $this->optionValue('pagination', true);
    }

    public function search()
    {
        return $this->optionValue('search', true);
    }

    public function export()
    {
        return $this->optionValue('export', true);
    }

    public function fields()
    {
        return $this->elements();
    }
}
