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

    public function name() : ?string
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

    public function isVisible()
    {
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

    public function pattern() : ?string
    {
        return $this->pattern;
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

    public function options() : iterable
    {
        return json_decode($this->options ?? '{}', true);
    }

    public function buildView(iterable $parent) : iterable
    {
        //dump('BUILD CELL VIEW : '.$this->element->name());
        //dump($parent);
        $view['element'] = $parent['element'];
        $view['state'] = $this->buildState($parent['state'], $parent['data']);
        $view['data'] = $parent['data'];
        $view['options'] = array_replace_recursive($parent['options'], $this->options());
        $view['children'] = [];
        return $this->element->buildView($view);
    }

    public function buildForms(iterable $view) : iterable
    {
        //dump('BUILD CELL : '.$this->element->name());
        return $this->element->buildForms($view);
    }

    public function buildForm(iterable $view, FormBuilderInterface $builder) : void
    {
        //dump('BUILD CELL FORM : '.$this->element->name());
        $this->element->buildForm($view, $builder);
    }

    public function renderView(iterable $view, iterable $forms = [], FormView $form = null) : string
    {
        //dump('RENDER CELL VIEW : '.$this->element->id());
        return $this->element->renderView($view, $forms, $form);
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
        $builder->addStringField('pattern', 30);
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

    protected function buildState(iterable $state, $data) : iterable
    {
        $state['name'] = $this->name;
        if ($this->label !== null) {
            $state['label'] = $this->label;
        }
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
        if ($this->pattern !== null) {
            $state['pattern'] = $this->pattern;
        }
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
}
