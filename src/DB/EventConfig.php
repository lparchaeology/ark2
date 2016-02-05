<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* php/arkdb/event_config.php
*
* ArkDB Event Configuration
* A class containing the configuration for an ARK Event
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
* @link       http://ark.lparchaeology.com/code/php/arkdb/event_config.php
* @since      2.0
*
*/

namespace LPArchaeology\ARK\DB;

class EventConfig
{
    private $_id = '';
    private $_valid = FALSE;
    private $_type = '';
    private $_dateField = NULL;
    private $_actionField = NULL;
    private $_options = array();

    // {{{ __construct()
    function __construct($event_id = NULL)
    {
        $this->_dateField = new FieldConfig();
        $this->_actionField = new FieldConfig();
        if ($event_id == NULL) {
            return;
        }
        $this->_id = $event_id;
        global $ado;
        $config = $ado->elementConfig($event_id, __METHOD__);
        if (count($config)) {
            $this->_valid = TRUE;
            $fields = FieldConfig::elementFields($event_id);
            foreach ($fields as $field) {
                if ($field->dataclass() == 'date') {
                    $this->_dateField = $field;
                } elseif ($field->dataclass() == 'action') {
                    $this->_actionField = $field;
                }
            }
            $options = Option::elementOptions($event_id);
            foreach ($options as $option) {
                if ($option->id() != 'type') {
                    $this->_type = $options->value();
                } else {
                    $this->_options[] = $option;
                }
            }
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
    // {{{ type()
    function type()
    {
        return $this->_type;
    }
    // }}}
    // {{{ dateField()
    function dateField()
    {
        return $this->_dateField;
    }
    // }}}
    // {{{ actionField()
    function actionField()
    {
        return $this->_actionField;
    }
    // }}}
    // {{{ options()
    function options()
    {
        return $this->_options;
    }
    // }}}
    // {{{ config()
    function config()
    {
        if (!$this->isValid()) {
            return array();
        }
        $config['type'] = $this->type();
        if ($this->dateField()->isValid()) {
            $config['date'] = $this->dateField()->config();
        } else {
            $config['date'] = FALSE;
        }
        if ($this->actionField()->isValid()) {
            $config['action'] = $this->actionField()->config();
        } else {
            $config['action'] = FALSE;
        }
        foreach ($this->options() as $option) {
            $config[$option->id()] = $option->value();
        }
        return $config;
    }
    // }}}
    // {{{ elementEvents()
    static function elementEvents($element_id, $enabled = TRUE)
    {
        global $ado;
        $children = $ado->elementGroup($element_id, 'event', $enabled, __METHOD__);
        $events = array();
        foreach ($children as $child) {
            $event = new EventConfig($child['child_id']);
            if ($event->isValid()) {
                $events[] = $event;
            }
        }
        return $events;
    }
    // }}}
}

?>
