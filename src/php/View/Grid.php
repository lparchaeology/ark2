<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/View/Grid.php
*
* ARK Grid View
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
* @see        http://ark.lparchaeology.com/code/src/php/View/Grid.php
* @since      2.0
*
*/

namespace ARK\View;

use ARK\Database\Database;
use Symfony\Component\Form\FormFactoryInterface;

class Grid extends Layout
{
    function __construct(Database $db = null, $layout = null, $module = null, $modtype = null)
    {
        if ($db == null || $layout == null) {
            return;
        }
        parent::__construct($db, $layout, $module, $modtype);
        $this->_template = 'layouts/grid.html.twig';
    }

    function cols($row)
    {
        return $this->_grid[$row];
    }

    function rows()
    {
        return $this->_grid;
    }

    function renderForms(FormFactoryInterface $factory, $itemKey)
    {
        $forms = array();
        foreach ($this->rows() as $rdx => $row) {
            foreach ($row as $cdx => $col) {
                foreach ($col as $cell) {
                    $forms[$rdx][$cdx][] = $cell->renderForms($factory, $itemKey);
                }
            }
        }
        return $forms;
    }

}