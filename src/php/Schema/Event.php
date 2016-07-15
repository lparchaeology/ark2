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

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Symfony\Component\Form\FormBuilder;
use ARK\Database\Database;
use ARK\Form\Type\EventType;

class Event extends Element
{
    private $_dateField = null;
    private $_actionField = null;

    // {{{ __construct()
    function __construct(Database $db, $event_id = null)
    {
        $this->_dateField = new Field($db);
        $this->_actionField = new Field($db);
        if ($event_id == null) {
            return;
        }
        try {
            parent::__construct($db, $event_id, 'event');
            $fields = Field::fetchFields($db, $event_id);
            foreach ($fields as $field) {
                if ($field->dataclass() == 'date') {
                    $this->_dateField = $field;
                } else if ($field->dataclass() == 'action') {
                    $this->_actionField = $field;
                }
            }
            $this->_valid = $this->_dateField->isValid() && $this->_actionField->isValid();
        } catch (DBALException $e) {
            echo 'Invalid config for event : '.$event_id;
            throw $e;
        }
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
    // {{{ buildForm()
    function formData($itemKey)
    {
        $data = array();
        $data[$this->id()] = array_merge(
            $this->_actionField->formData($itemKey),
            $this->_dateField->formData($itemKey)
        );
        return $data;
    }
    // }}}
    // {{{ buildForm()
    function buildForm(FormBuilder &$formBuilder, array $options = array())
    {
        if (!$this->isValid()) {
            return;
        }
        $options['label'] = false;
        $options['title'] = $this->_id;
        $options['eventAction'] = $this->_actionField;
        $options['eventDate'] = $this->_dateField;
        $formBuilder->add($this->_id, EventType::class, $options);
    }
    // }}}
    // {{{ toSchema()
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
            $this->_actionField->toSchema(),
            $this->_dateField->toSchema()
        );
        $schema['required'] = array(
            $this->_actionField->id(),
            $this->_dateField->id(),
        );
        $schema['additionalProperties'] = false;
        return array($this->_id => $schema);
    }
    // }}}
    // {{{ allFields()
    function allFields()
    {
        return array($this->_actionField, $this->_dateField);
    }
    // }}}
    // {{{ fetchEvents()
    static function fetchEvents(Connection $db, $element_id, $enabled = true)
    {
        $children = Element::fetchGroupArrays($db, $element_id, 'event', $enabled);
        $events = array();
        foreach ($children as $child) {
            $event = new Event($child['child_id']);
            if ($event->isValid()) {
                $events[] = $event;
            }
        }
        return $events;
    }
    // }}}
}
