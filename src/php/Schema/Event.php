<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Schema/Event.php
*
* ARK Schema Event
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
* @see        http://ark.lparchaeology.com/code/src/php/Schema/Event.php
* @since      2.0
*
*/

namespace ARK\Schema;

use Symfony\Component\Form\FormBuilder;
use ARK\Database\Database;
use ARK\Form\Type\EventType;

class Event extends Element
{
    private $_date = null;
    private $_action = null;

    function __construct(Database $db = null, $event_id = null)
    {
        $this->_date = new Field();
        $this->_action = new Field();
        if ($db == null || $event_id == null) {
            return;
        }
        parent::__construct($db, $event_id, 'event');
        $fields = Field::fetchFields($db, $event_id);
        foreach ($fields as $field) {
            if ($field->dataclass() == 'date') {
                $this->_date = $field;
            } else if ($field->dataclass() == 'action') {
                $this->_action = $field;
            }
        }
        $this->_valid = $this->_date->isValid() && $this->_action->isValid();
    }

    function date()
    {
        return $this->_date;
    }

    function action()
    {
        return $this->_action;
    }

    function formData($itemKey)
    {
        $data = array();
        $data[$this->id()] = array_merge(
            $this->_action->formData($itemKey),
            $this->_date->formData($itemKey)
        );
        return $data;
    }

    function buildForm(FormBuilder &$formBuilder, array $options = array())
    {
        if (!$this->isValid()) {
            return;
        }
        $options['label'] = false;
        $options['title'] = $this->_id;
        $options['eventAction'] = $this->_action;
        $options['eventDate'] = $this->_date;
        $formBuilder->add($this->_id, EventType::class, $options);
    }

    function toSchema()
    {
        if (!$this->isValid()) {
            return '';
        }
        $schema = array();
        $schema['type'] = 'object';
        $schema['title'] = $this->_title;
        $schema['description'] = $this->_description;
        $schema['properties'] = array_merge(
            $this->_action->toSchema(),
            $this->_date->toSchema()
        );
        $schema['required'] = array(
            $this->_action->id(),
            $this->_date->id(),
        );
        $schema['additionalProperties'] = false;
        return array($this->_id => $schema);
    }

    function allFields()
    {
        return array($this->_action, $this->_date);
    }

}
