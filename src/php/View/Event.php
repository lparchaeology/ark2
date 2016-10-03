<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/View/Event.php
*
* ARK View Event
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
* @see        http://ark.lparchaeology.com/code/src/php/View/Event.php
* @since      2.0
*
*/

namespace ARK\View;

use Symfony\Component\Form\FormBuilder;
use ARK\Database\Database;
use ARK\Model\AbstractResource;
use ARK\Form\Type\EventType;

class Event extends Element
{
    private $date = null;
    private $actions = array();

    protected function __construct(Database $db, string $event)
    {
        parent::__construct($db, $event);
    }

    protected function init(array $config, AbstractResource $resource = null)
    {
        parent::init($config, $resource);
        $fields = Field::fetchFields($this->db, $this->id());
        foreach ($fields as $field) {
            if ($field->property()->dataclass() == 'date' && $field->isValid()) {
                $this->date = $field;
            } elseif ($field->property()->dataclass() == 'action' && $field->isValid()) {
                $this->actions[] = $field;
            }
        }
        $this->valid = $this->date && $this->actions;
    }

    public function date()
    {
        return $this->date;
    }

    public function actions()
    {
        return $this->actions;
    }

    public function formData()
    {
        $data = array();
        $data[$this->id()] = array_merge(
            // TODO Do all actions
            $this->actions[0]->formData(),
            $this->date->formData()
        );
        return $data;
    }

    public function buildForm(FormBuilder &$formBuilder, array $options = array())
    {
        if (!$this->isValid()) {
            return;
        }
        $options['label'] = false;
        $options['title'] = $this->id;
        $options['eventActions'] = $this->actions;
        $options['eventDate'] = $this->date;
        $formBuilder->add($this->id, EventType::class, $options);
    }

    public function allFields()
    {
        return array_merge($this->actions, array($this->date));
    }
}
