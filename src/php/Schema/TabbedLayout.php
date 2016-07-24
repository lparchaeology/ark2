<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Schema/TabbedLayout.php
*
* ARK Schema TabbedLayout
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
* @see        http://ark.lparchaeology.com/code/src/php/Schema/TabbedLayout.php
* @since      2.0
*
*/

namespace ARK\Schema;

use ARK\Database\Database;
use Symfony\Component\Form\FormFactoryInterface;

class TabbedLayout extends Layout
{
    function __construct(Database $db = null, $layout_id = null, $modname = null, $modtype = null)
    {
        if ($db == null || $layout_id == null) {
            return;
        }
        parent::__construct($db, $layout_id, $modname, $modtype);
    }

    function toggle()
    {
        if (isset($this->_options['toggle'])) {
            return $this->_options['toggle'];
        } else {
            return 'tab';
        }
    }

    function justified()
    {
        if (isset($this->_options['justified'])) {
            return $this->_options['justified'];
        } else {
            return false;
        }
    }

    function fade()
    {
        if (isset($this->_options['fade'])) {
            return $this->_options['fade'];
        } else {
            return false;
        }
    }

    function showSingleTab()
    {
        if (isset($this->_options['show_single_tab'])) {
            return $this->_options['show_single_tab'];
        } else {
            return false;
        }
    }

    function defaultTab()
    {
        if (isset($this->_options['default_tab'])) {
            return $this->_options['default_tab'];
        } else {
            return $this->tabs()[0]->id();
        }
    }

    function tabs()
    {
        return $this->elements();
    }

    function renderForms(FormFactoryInterface $factory, $itemKey)
    {
        $forms = array();
        foreach ($this->tabs() as $tab) {
            $forms[$tab->id()] = $tab->renderForms($factory, $itemKey);
        }
        return $forms;
    }

}
