<?php

/**
 * ARK View Group.
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
 * @copyright  2017 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\View;

use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Service;
use Symfony\Component\Form\FormBuilderInterface;

class Form extends Element
{
    use GridTrait;

    protected $method = '';
    protected $action = '';

    public function formMethod() : string
    {
        return $this->method ?? '';
    }

    public function formAction() : string
    {
        return $this->action ?? '';
    }

    public function buildForms(iterable $view) : iterable
    {
        //dump('BUILD FORMS : '.$this->id().' '.$this->name());
        //dump($view);
        if ($view['state']['mode'] === 'deny') {
            return [];
        }
        $name = $view['state']['name'] ?? '';
        $options = $view['options'];
        $options['attr']['id'] = $name;
        $builder = $this->formBuilder($name, $view['data'], $options);
        if ($this->method) {
            $builder->setMethod($this->method);
        }
        if ($this->action) {
            $builder->setAction(Service::path($this->action));
        }
        $this->buildForm($view, $builder);
        return [$name => $builder->getForm()];
    }

    public function buildForm(iterable $view, FormBuilderInterface $builder) : void
    {
        //dump('BUILD FORM : '.$this->id());
        //dump($view);
        if ($view['state']['mode'] === 'deny') {
            return;
        }
        foreach ($view['children'] as $row) {
            foreach ($row as $col) {
                foreach ($col as $child) {
                    $child['element']->buildForm($child, $builder);
                }
            }
        }
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_form');
        $builder->setReadOnly();

        // Fields
        $builder->addStringField('name', 30);
        $builder->addStringField('mode', 10);
        $builder->addStringField('method', 10);
        $builder->addStringField('action', 30);
        KeywordTrait::buildKeywordMetadata($builder);
        $builder->addStringField('template', 100);
        $builder->addMappedStringField('form_type', 'formType', 100);

        // Associations
        $builder->addOneToMany('cells', Cell::class, 'group');
    }
}
