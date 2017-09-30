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
use ARK\Vocabulary\Term;
use ARK\Workflow\Permission;
use Symfony\Component\Form\Form;

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

    public function header() : ?Group
    {
        return $this->header;
    }

    public function sidebar() : ?Group
    {
        return $this->sidebar;
    }

    public function content() : ?Group
    {
        return $this->content;
    }

    public function footer() : ?Group
    {
        return $this->footer;
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
        $builder->addManyToOneField('header', Group::class, 'header', 'element');
        $builder->addManyToOneField('sidebar', Group::class, 'sidebar', 'element');
        $builder->addManyToOneField('content', Group::class, 'content', 'element');
        $builder->addManyToOneField('footer', Group::class, 'footer', 'element');
        $builder->addPermissionField('read', 'view');
        $builder->addPermissionField('update', 'edit');
    }

    protected function buildState($data, iterable $state) : iterable
    {
        $state = array_replace_recursive($this->defaultState(), $state);
        $state = parent::buildState($data, $state);

        $mode = $state['workflow']['mode'];
        if ($this->visibility === 'restricted') {
            $actor = $state['actor'];
            if ($mode === 'edit' && !$actor->hasPermission($this->updatePermission())) {
                $mode = 'view';
            }
            if ($mode === 'view' && !$actor->hasPermission($this->readPermission())) {
                $mode = 'deny';
            }
        }
        if ($this->visibility === 'private') {
            // TODO What?
        }
        $state['mode'] = $mode;

        $state['page'] = $this;
        return $state;
    }

    protected function pageContext($data, iterable $state, iterable $forms = null) : iterable
    {
        $context = $this->buildContext($data, $state);
        $context['page'] = $this;
        $context['layout'] = $this->content();
        $views = null;
        if ($forms) {
            foreach ($forms as $name => $form) {
                if ($form) {
                    $views[$name] = $form->createView();
                }
            }
        }
        $context['state']['forms'] = $views;
        $context['forms'] = $views;
        $context['form'] = null;
        return $context;
    }
}
