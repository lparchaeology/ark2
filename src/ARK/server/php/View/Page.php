<?php

/**
 * ARK Page View.
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

use ARK\Actor\Actor;
use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Vocabulary\Term;
use ARK\Workflow\Permission;

class Page extends Element
{
    protected $visibility = 'restricted';
    protected $visibilityTerm;
    protected $read;
    protected $update;
    protected $header;
    protected $sidebar;
    protected $content;
    protected $footer;

    public function visibility() : Term
    {
        if ($this->visibilityTerm === null) {
            $this->visibilityTerm = ORM::find(Term::class, ['concept' => 'core.visibility', 'term' => $this->visibility]);
        }
        return $this->visibilityTerm;
    }

    public function readPermission() : ?Permission
    {
        return $this->read;
    }

    public function updatePermission() : ?Permission
    {
        return $this->update;
    }

    public function header() : ?Element
    {
        return $this->header;
    }

    public function sidebar() : ?Element
    {
        return $this->sidebar;
    }

    public function content() : ?Element
    {
        return $this->content;
    }

    public function footer() : ?Element
    {
        return $this->footer;
    }

    public function pageMode(Actor $actor) : string
    {
        if ($this->mode === 'deny') {
            return 'deny';
        }
        if ($this->visibility === 'public' || $actor->hasPermission($this->updatePermission())) {
            return $this->mode;
        }
        if ($actor->hasPermission($this->readPermission())) {
            return 'read';
        }
        return 'deny';
    }

    public function buildView(iterable $parent = []) : iterable
    {
        dump('BUILD PAGE VIEW : '.get_class($this).' '.$this->id().' '.$this->name().' '.$this->keyword());
        //dump($parent);
        $view = parent::buildView($parent);
        if ($this->content()) {
            $childView = $view;
            unset($childView['state']['template'], $childView['state']['form']['type']);
            $view['children'][] = $this->content()->buildView($childView);
        }
        dump($view);
        return $view;
    }

    public function buildForms(iterable $view) : iterable
    {
        //dump('PAGE FORMS : '.$this->id());
        //dump($view);
        $child = $view['children'][0] ?? [];
        return isset($child['element']) ? $child['element']->buildForms($child) : [];
    }

    public function createFormViews(iterable $forms) : iterable
    {
        $views = [];
        foreach ($forms as $name => $form) {
            if ($form) {
                $views[$name] = $form->createView();
            }
        }
        return $views;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_page');

        // Fields
        $builder->addStringField('mode', 10);
        $builder->addStringField('visibility', 30);
        KeywordTrait::buildKeywordMetadata($builder);
        $builder->addStringField('template', 100);

        // Associations
        $builder->addManyToOneField('header', Element::class, 'header', 'element');
        $builder->addManyToOneField('sidebar', Element::class, 'sidebar', 'element');
        $builder->addManyToOneField('content', Element::class, 'content', 'element');
        $builder->addManyToOneField('footer', Element::class, 'footer', 'element');
        $builder->addPermissionField('view', 'read');
        $builder->addPermissionField('edit', 'update');
    }

    protected function buildState($data, iterable $state) : iterable
    {
        $state = array_replace_recursive($this->defaultState(), $state);
        $state = parent::buildState($data, $state);

        $mode = $state['workflow']['mode'];
        $actor = $state['actor'];
        if ($mode === 'edit' && !$actor->hasPermission($this->updatePermission())) {
            $mode = 'view';
        }
        $state['mode'] = $mode;
        $state['page'] = $this;
        return $state;
    }
}
