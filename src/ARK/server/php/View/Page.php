<?php

/**
 * ARK Page View.
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

use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Security\Actor;
use ARK\Security\Permission;
use ARK\Vocabulary\Term;

class Page extends Element
{
    protected $visibility = 'restricted';
    protected $visibilityTerm;
    protected $viewPermission;
    protected $editPermission;
    protected $header;
    protected $sidebar;
    protected $content;
    protected $footer;
    protected $package = 'frontend';
    protected $absoluteUrl = false;
    protected $script;
    protected $stylesheet;

    public function visibility() : Term
    {
        if ($this->visibilityTerm === null) {
            $this->visibilityTerm = ORM::find(Term::class, ['concept' => 'core.visibility', 'term' => $this->visibility]);
        }
        return $this->visibilityTerm;
    }

    public function viewPermission() : ?Permission
    {
        return $this->viewPermission;
    }

    public function editPermission() : ?Permission
    {
        return $this->editPermission;
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

    public function assetPackage() : string
    {
        return $this->package ?? 'frontend';
    }

    public function useAbsoluteAssetUrls() : string
    {
        return $this->absoluteUrl ?? false;
    }

    public function script() : string
    {
        return $this->script ?? $this->id();
    }

    public function stylesheet() : string
    {
        return $this->stylesheet ?? $this->id();
    }

    public function pageMode(Actor $actor) : string
    {
        if ($this->mode === 'deny') {
            return 'deny';
        }
        if ($this->visibility === 'public' || $actor->hasPermission($this->editPermission())) {
            return $this->mode;
        }
        if ($actor->hasPermission($this->viewPermission())) {
            return 'viewPermission';
        }
        return 'deny';
    }

    public function buildView(iterable $parent = []) : iterable
    {
        //dump('BUILD PAGE VIEW : '.get_class($this).' '.$this->id().' '.$this->name().' '.$this->keyword());
        //dump($parent);
        $view = parent::buildView($parent);
        if ($this->content()) {
            $childView = $view;
            unset($childView['state']['template'], $childView['state']['form']['type']);
            $view['children'][] = $this->content()->buildView($childView);
        }
        //dump($view);
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
        $builder->addStringField('package', 30);
        $builder->addMappedField('absolute_url', 'absoluteUrl');
        $builder->addStringField('script', 30);
        $builder->addStringField('stylesheet', 30);
        $builder->addStringField('template', 100);

        // Associations
        $builder->addManyToOneField('header', Element::class, 'header', 'element');
        $builder->addManyToOneField('sidebar', Element::class, 'sidebar', 'element');
        $builder->addManyToOneField('content', Element::class, 'content', 'element');
        $builder->addManyToOneField('footer', Element::class, 'footer', 'element');
        $builder->addPermissionField('view_permission', 'viewPermission');
        $builder->addPermissionField('edit_permission', 'editPermission');
    }

    protected function buildState($data, iterable $state) : iterable
    {
        $state = array_replace_recursive($this->defaultState(), $state);
        $state = parent::buildState($data, $state);

        $mode = $state['workflow']['mode'];
        $actor = $state['actor'];
        if ($mode === 'edit' && !$actor->hasPermission($this->editPermission())) {
            $mode = 'view';
        }
        $state['mode'] = $mode;
        $state['page'] = $this;
        return $state;
    }
}
