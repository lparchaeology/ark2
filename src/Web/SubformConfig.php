<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* php/arkweb/subform_config.php
*
* ArkDB Subform Configuration
* A class containing the configuration for an Ark Subform
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
* @category   base
* @package    ark
* @author     John Layt <j.layt@lparchaeology.com>
* @copyright  2016 L - P : Heritage LLP
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/code/php/arkweb/subform_config.php
* @since      2.0
*
*/

namespace LPArchaeology\ARK\Web;
use LPArchaeology\ARK;

class SubformConfig
{
    private $_id = '';
    private $_valid = FALSE;
    private $_enabled = FALSE;
    private $_viewState = '';
    private $_editState = '';
    private $_navType = '';
    private $_title = '';
    private $_script = '';
    private $_label = NULL;
    private $_input = NULL;
    private $_options = array();
    private $_conditions = array();
    private $_subforms = array();
    private $_events = array();
    private $_fields = array();
    private $_links = array();

    // {{{ __construct()
    function __construct($subform_id = NULL)
    {
        if ($subform_id == NULL) {
            return;
        }
        $this->_id = $subform_id;
        global $ado;
        $config = $ado->subformConfig($subform_id, __METHOD__);
        if (count($config)) {
            $this->_valid = TRUE;
            $this->_viewState = $config['view_state'];
            $this->_editState = $config['edit_state'];
            $this->_navType = $config['nav_type'];
            $this->_title = $config['title'];
            $this->_script = $config['script'];
            $this->_label = $config['label'];
            $this->_input = $config['input'];
            $this->_options = ARK\DB\Option::elementOptions($subform_id);
            $this->_conditions = ARK\DB\Condition::elementConditions($subform_id);
            $this->_subforms = SubformConfig::elementSubforms($subform_id);
            $this->_events = ARK\DB\EventConfig::elementEvents($subform_id);
            $this->_fields = ARK\DB\FieldConfig::elementFields($subform_id);
            $this->_links = ARK\Web\Link::elementLinks($subform_id);
        }
    }
    // }}}
    // {{{ id()
    function id()
    {
        return $this->_id;
    }
    // }}}
    // {{{ isValid()
    function isValid()
    {
        return $this->_valid;
    }
    // }}}
    // {{{ viewState()
    function viewState()
    {
        return $this->_viewState;
    }
    // }}}
    // {{{ editState()
    function editState()
    {
        return $this->_editState;
    }
    // }}}
    // {{{ navType()
    function navType()
    {
        return $this->_navType;
    }
    // }}}
    // {{{ title()
    function title()
    {
        return $this->_title;
    }
    // }}}
    // {{{ script()
    function script()
    {
        return $this->_script;
    }
    // }}}
    // {{{ label()
    function label()
    {
        return $this->_label;
    }
    // }}}
    // {{{ input()
    function input()
    {
        return $this->_input;
    }
    // }}}
    // {{{ options()
    function options()
    {
        return $this->_options;
    }
    // }}}
    // {{{ conditions()
    function conditions()
    {
        return $this->_conditions;
    }
    // }}}
    // {{{ subforms()
    function subforms()
    {
        return $this->_subforms;
    }
    // }}}
    // {{{ events()
    function events()
    {
        return $this->_events;
    }
    // }}}
    // {{{ fields()
    function fields()
    {
        return $this->_fields;
    }
    // }}}
    // {{{ links()
    function links()
    {
        return $this->_links;
    }
    // }}}
    // {{{ config()
    function config()
    {
        if (!$this->isValid()) {
            return array();
        }
        $config['view_state'] = $this->viewState();
        $config['edit_state'] = $this->editState();
        $config['sf_title'] = $this->title();
        $config['sf_html_id'] = $this->id();
        $config['sf_nav_type'] = $this->navType();
        $config['script'] = $this->script();
        $config['op_label'] = $this->label();
        $config['op_input'] = $this->input();
        foreach ($this->options() as $option) {
            if ($option->isValid()) {
                $config[$option->id()] = $option->value();
            }
        }
        foreach ($this->conditions() as $condition) {
            if ($condition->isValid()) {
                $config['op_condition'][] = $condition->config();
            }
        }
        foreach ($this->subforms() as $subform) {
            if ($subform->isValid()) {
                $config['subforms'][] = $subform->config();
            }
        }
        foreach ($this->events() as $event) {
            if ($event->isValid()) {
                $config['events'][] = $event->config();
            }
        }
        foreach ($this->fields() as $field) {
            if ($field->isValid()) {
                $config['fields'][] = $field->config();
            }
        }
        foreach ($this->links() as $link) {
            if ($link->isValid()) {
                $config['links'][] = $link->config();
            }
        }
        return $config;
    }
    // }}}
    // {{{ elementSubforms()
    static function elementSubforms($element_id, $enabled = TRUE)
    {
        global $ado;
        $children = $ado->elementGroup($element_id, 'subform', $enabled, __METHOD__);
        $subforms = array();
        foreach ($children as $child) {
             $subform = new SubformConfig($child['child_id']);
            if ($subform->isValid()) {
                $subforms[] =  $subform;
            }
        }
        return $subforms;
    }
    // }}}
}

?>
