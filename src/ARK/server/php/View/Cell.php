<?php

/**
 * ARK View Cell.
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

use ARK\Map\Map;
use ARK\Model\EnabledTrait;
use ARK\Model\Item;
use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Service;
use ARK\Vocabulary\Vocabulary;
use ARK\Workflow\Action;
use ARK\Workflow\Permission;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;

class Cell implements ElementInterface
{
    use EnabledTrait;
    use KeywordTrait;

    protected $group;
    protected $row = 0;
    protected $col = 0;
    protected $seq = 0;
    protected $class = '';
    protected $element;
    protected $name = '';
    protected $width = 0;
    protected $map;
    protected $vocabulary;
    protected $label = false;
    protected $help = false;
    protected $placeholder = false;
    protected $choices = false;
    protected $required = false;
    protected $action;
    protected $viewPermission;
    protected $editPermission;
    protected $mode;
    protected $sanitise;
    protected $visible = true;
    protected $pattern;
    protected $value;
    protected $parameter;
    protected $format;
    protected $display;
    protected $template;
    protected $options;
    protected $optionsArray;

    public function group() : Element
    {
        return $this->group;
    }

    public function row() : int
    {
        return $this->row;
    }

    public function col() : int
    {
        return $this->col;
    }

    public function seq() : int
    {
        return $this->seq;
    }

    public function class() : string
    {
        return $this->class;
    }

    public function element() : Element
    {
        return $this->element;
    }

    public function map() : ?Map
    {
        return $this->map;
    }

    public function vocabulary() : ?Vocabulary
    {
        return $this->vocabulary;
    }

    public function formName() : ?string
    {
        return $this->name;
    }

    public function width() : ?int
    {
        return $this->width;
    }

    public function showLabel() : bool
    {
        return $this->label;
    }

    public function showHelp() : bool
    {
        return $this->help;
    }

    public function showPlaceholder() : ?bool
    {
        return $this->placeholder;
    }

    public function showChoices() : ?bool
    {
        return $this->choices;
    }

    public function isRequired() : bool
    {
        return $this->required;
    }

    public function isVisible() {
        return $this->visible ?? true;
    }

    public function action() : ?Action
    {
        return $this->action;
    }

    public function viewPermission() : ?Permission
    {
        return $this->viewPermission;
    }

    public function editPermission() : ?Permission
    {
        return $this->editPermission;
    }

    public function mode() : string
    {
        return $this->mode;
    }

    public function sanitise() : ?string
    {
        return $this->sanitise;
    }

    public function valueModus() : ?string
    {
        return $this->value;
    }

    public function parameterModus() : ?string
    {
        return $this->parameter;
    }

    public function formatModus() : ?string
    {
        return $this->format;
    }

    public function template() : string
    {
        return $this->template ?? '';
    }

    public function buildState($data, iterable $state) : iterable
    {
        $state['name'] = $this->name;
        $state['label'] = $this->label;
        $state['help'] = $this->help;
        $state['placeholder'] = $this->placeholder;
        $state['choices'] = $this->choices;
        $state['map'] = $this->map;
        $state['vocabulary'] = $this->vocabulary;
        if ($this->required === false) {
            $state['required'] = false;
        }
        if ($this->sanitise !== null) {
            $state['sanitise'] = $this->sanitise;
	}
	$state['visible'] = $this->visible ?? true;
        if ($this->width !== null) {
            $state['width'] = $this->width;
        }
        if ($this->display) {
            $state['display']['name'] = $this->display;
        }
        $state['keyword'] = $this->keyword;
        $actor = Service::workflow()->actor();
        if (!$actor->hasPermission($this->editPermission)) {
            $state['mode'] = 'view';
        } elseif ($this->mode === 'view') {
            $state['mode'] = 'view';
        }
        if (!$actor->hasPermission($this->viewPermission)) {
            $state['mode'] = 'deny';
        }
        $state['action'] = $this->action;
        if ($this->action && $data instanceof Item && !$actor->canAction($this->action, $data)) {
            $state['mode'] = 'deny';
        }
        if ($this->valueModus() !== null) {
            $state['value']['modus'] = $this->valueModus();
        }
        if ($this->parameterModus() !== null) {
            $state['parameter']['modus'] = $this->parameterModus();
        }
        if ($this->formatModus() !== null) {
            $state['format']['modus'] = $this->formatModus();
        }
        if (!isset($state['sanitise']) || $this->sanitise) {
            $state['sanitise'] = $this->sanitise;
        }
        return $state;
    }

    public function buildData($data, iterable $state)
    {
        return $data;
    }

    public function buildOptions($data, iterable $state, iterable $options = []) : iterable
    {
        if ($this->optionsArray === null) {
            $this->optionsArray = json_decode($this->options, true);
            if (!is_array($this->optionsArray)) {
                $this->optionsArray = [];
            }
        }
        $options = array_replace_recursive($options, $this->optionsArray);
        return $options;
    }

    public function buildForms($data, iterable $state, iterable $options) : iterable
    {
        //dump('BUILD CELL : '.$this->element->formName());
        if ($this->element->type()->isLayout()) {
            $state = $this->buildState($data, $state);
            return $this->element->buildForms($data, $state, $options);
        }
        return [];
    }

    public function buildForm(FormBuilderInterface $builder, $data, iterable $state, iterable $options = []) : void
    {
        //dump('BUILD CELL FORM : '.$this->element->formName());
        //dump($data);
        //dump($state);
        //dump($options);
        $state = $this->buildState($data, $state);
        //dump($state);
        $data = $this->buildData($data, $state);
        $options = $this->buildOptions($data, $state, $options);
        $this->element->buildForm($builder, $data, $state, $options);
    }

    public function renderForm($data, iterable $state, FormView $form = null) : string
    {
        //dump('RENDER CELL FORM : '.$this->element->id());
        //dump($state);
        //dump($data);
        $state = $this->buildState($data, $state);
        return $this->element->renderForm($data, $state, $form);
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_cell');
        $builder->setReadOnly();

        // Key
        $builder->addManyToOneKey('group', 'ARK\View\Element', 'grp', 'element');
        $builder->addKey('row', 'integer');
        $builder->addKey('col', 'integer');
        $builder->addKey('seq', 'integer');
        $builder->addStringKey('class', 30);

        // Fields
        $builder->addStringField('name', 30);
        $builder->addField('width', 'integer');
        $builder->addField('label', 'boolean');
        $builder->addField('help', 'boolean');
        $builder->addField('placeholder', 'boolean');
        $builder->addField('choices', 'boolean');
        $builder->addStringField('mode', 10);
	$builder->addStringField('sanitise', 10);
	$builder->addField('visible', 'boolean');
        $builder->addStringField('value', 10);
        $builder->addStringField('parameter', 10);
        $builder->addStringField('format', 10);
        $builder->addStringField('display', 30);
        $builder->addStringField('template', 100);
        $builder->addStringField('options', 4000);
        $builder->addField('required', 'boolean');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Relationships
        $builder->addManyToOneField('element', Element::class, 'element', 'element', false);
        $builder->addManyToOneField('map', Map::class);
        $builder->addManyToOneField('vocabulary', Vocabulary::class, 'vocabulary', 'concept');
        $builder->addCompositeManyToOneField('action', Action::class, [
            [
                'column' => 'action_schema',
                'reference' => 'schma',
                'nullable' => true,
            ],
            [
                'column' => 'action',
                'nullable' => true,
            ],
        ]);
        $builder->addManyToOneField('viewPermission', Permission::class, 'view', 'permission');
        $builder->addManyToOneField('editPermission', Permission::class, 'edit', 'permission');
    }
}
