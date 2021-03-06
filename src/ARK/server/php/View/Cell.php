<?php

/**
 * ARK View Cell.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
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
 * @copyright  2018 L - P : Heritage LLP.
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
use ARK\Security\Permission;
use ARK\Service;
use ARK\Vocabulary\Concept;
use ARK\Workflow\Action;
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
    protected $name;
    protected $required = false;
    protected $default;
    protected $label = false;
    protected $help = false;
    protected $info = false;
    protected $visible = true;
    protected $width;
    protected $placeholder = false;
    protected $choices = false;
    protected $exportable;
    protected $sortable;
    protected $sorter;
    protected $order;
    protected $vocabulary;
    protected $map;
    protected $action;
    protected $viewPermission;
    protected $editPermission;
    protected $mode;
    protected $sanitise;
    protected $valueModus;
    protected $parameterModus;
    protected $formatModus;
    protected $template;
    protected $options;
    protected $formType;
    protected $formOptions = '';
    protected $formOptionsArray;

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

    public function name() : ?string
    {
        return $this->name;
    }

    public function isRequired() : bool
    {
        return $this->required;
    }

    public function isDefault() : bool
    {
        return $this->default;
    }

    public function showLabel() : ?bool
    {
        return $this->label;
    }

    public function showHelp() : bool
    {
        return $this->help;
    }

    public function showInfo() : bool
    {
        return $this->info;
    }

    public function isVisible() : bool
    {
        return $this->visible;
    }

    public function width() : ?int
    {
        return $this->width;
    }

    public function showPlaceholder() : ?bool
    {
        return $this->placeholder;
    }

    public function showChoices() : ?bool
    {
        return $this->choices;
    }

    public function exportable() : ?bool
    {
        return $this->exportable;
    }

    public function sortable() : ?bool
    {
        return $this->sortable;
    }

    public function sorter() : ?string
    {
        return $this->sorter;
    }

    public function sortOrder() : ?string
    {
        return $this->order;
    }

    public function vocabulary() : ?Concept
    {
        return $this->vocabulary;
    }

    public function map() : ?Map
    {
        return $this->map;
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
        return $this->valueModus;
    }

    public function parameterModus() : ?string
    {
        return $this->parameterModus;
    }

    public function formatModus() : ?string
    {
        return $this->formatModus;
    }

    public function template() : ?string
    {
        return $this->template;
    }

    public function options() : iterable
    {
        return json_decode($this->options ?? '{}', true);
    }

    public function formType() : ?string
    {
        return $this->formType;
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
        //dump($view);
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
        $builder->addManyToOneKey('group', Element::class, 'grp', 'element');
        $builder->addKey('row', 'integer');
        $builder->addKey('col', 'integer');
        $builder->addKey('seq', 'integer');
        $builder->addStringKey('class', 30);

        // Fields
        $builder->addStringField('name', 30);
        $builder->addField('required', 'boolean');
        $builder->addMappedField('is_default', 'default', 'boolean');
        $builder->addField('label', 'boolean');
        $builder->addField('help', 'boolean');
        $builder->addField('info', 'boolean');
        $builder->addField('visible', 'boolean');
        $builder->addField('width', 'integer');
        $builder->addField('placeholder', 'boolean');
        $builder->addField('choices', 'boolean');
        $builder->addField('exportable', 'boolean');
        $builder->addField('sortable', 'boolean');
        $builder->addStringField('sorter', 20);
        $builder->addMappedStringField('sort_order', 'order', 10);
        $builder->addStringField('mode', 10);
        $builder->addStringField('sanitise', 10);
        $builder->addMappedStringField('value_modus', 'valueModus', 10);
        $builder->addMappedStringField('parameter_modus', 'parameterModus', 10);
        $builder->addMappedStringField('format_modus', 'formatModus', 10);
        $builder->addStringField('template', 100);
        $builder->addStringField('options', 4000);
        $builder->addMappedStringField('form_type', 'formType', 100);
        $builder->addMappedStringField('form_options', 'formOptions', 4000);
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Relationships
        $builder->addRequiredManyToOneField('element', Element::class);
        $builder->addManyToOneField('map', Map::class);
        $builder->addVocabularyField('vocabulary');
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
        $builder->addPermissionField('view_permission', 'viewPermission');
        $builder->addPermissionField('view_permission', 'editPermission');
    }

    protected function buildState(iterable $state, $data) : iterable
    {
        // Cell state that is always propogated
        $state['name'] = $this->name;
        $state['default'] = $this->default;
        $state['help'] = $this->help;
        $state['info'] = $this->info;
        $state['placeholder'] = $this->placeholder;
        $state['visible'] = $this->visible ?? true;
        $state['width'] = $this->width;
        $state['exportable'] = $this->exportable ?? false;
        $state['sortable'] = $this->sortable ?? false;
        $state['sorter'] = $this->sorter ?? 'alphanumeric';
        $state['order'] = $this->order ?? 'asc';
        $state['choices'] = $this->choices;
        $state['vocabulary'] = $this->vocabulary;
        $state['map'] = $this->map;
        $state['keyword'] = $this->keyword;
        $state['action'] = $this->action;
        $state['template'] = $this->template();
        $state['form']['type'] = $this->formType();

        // TODO check logic on this, implies cell can override schema required field?
        if ($this->required === false) {
            $state['required'] = false;
        }

        // Cell state that is only propogated if set, otherwise child must set
        $this->addState($state, 'label', $this->showLabel());
        $this->addState($state, 'sanitise', $this->sanitise());

        $this->addSubState($state, 'value', 'modus', $this->valueModus());
        $this->addSubState($state, 'parameter', 'modus', $this->parameterModus());
        $this->addSubState($state, 'format', 'modus', $this->formatModus());

        // Override the mode if set at Cell level
        $actor = Service::workflow()->actor();
        if ($this->action && $data instanceof Item && !$actor->canAction($this->action, $data)) {
            $state['mode'] = 'deny';
        } elseif (!$actor->hasPermission($this->viewPermission())) {
            $state['mode'] = 'deny';
        } elseif (!$actor->hasPermission($this->editPermission())) {
            $state['mode'] = 'view';
        } elseif ($this->mode === 'view') {
            $state['mode'] = 'view';
        }

        return $state;
    }

    private function addState(iterable &$state, $key, $value) : void
    {
        if ($value !== null) {
            $state[$key] = $value;
        }
    }

    private function addSubState(iterable &$state, $key, $subkey, $value) : void
    {
        if ($value !== null) {
            $state[$key][$subkey] = $value;
        }
    }
}
