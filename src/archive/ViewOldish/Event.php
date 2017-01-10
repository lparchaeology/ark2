<?php

/**
 * ARK View Event
 *
 * Copyright (C) 2017  L - P : Heritage LLP.
 *
 * This file is part of ARK, the Archaeological Recording Kit.
 *
 * ARK is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ARK is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ARK.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     John Layt <j.layt@lparchaeology.com>
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\View;

use Symfony\Component\Form\FormBuilder;
use ARK\Database\Database;
use ARK\Model\Item\Item;
use ARK\Form\Type\EventType;

class Event extends Element
{
    private $date = null;
    private $actions = array();

    protected function __construct(Database $db, /*string*/ $event)
    {
        parent::__construct($db, $event);
    }

    protected function init(array $config, Item $resource = null)
    {
        parent::init($config, $resource);
        $fields = Field::fetchFields($this->db, $this->id());
        foreach ($fields as $field) {
            if ($field->property()->type() == 'date' && $field->isValid()) {
                $this->date = $field;
            } elseif ($field->property()->type() == 'action' && $field->isValid()) {
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
