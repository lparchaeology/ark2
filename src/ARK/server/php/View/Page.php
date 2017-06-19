<?php

/**
 * ARK Page View
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
 * @php        >=5.6, >=7.0
 */

namespace ARK\View;

use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ClassMetadata;
use ARK\Actor\Actor;
use ARK\Service;
use ARK\View\Group;
use ARK\View\Element;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

class Page extends Element
{
    protected $visibility = 'restricted';
    protected $visibilityTerm = null;
    protected $read = null;
    protected $update = null;
    protected $header = null;
    protected $sidebar = null;
    protected $content = null;
    protected $footer = null;

    public function pageMode(Actor $actor, Item $item = null)
    {
        // TODO Move check to Security or Workflow???
        $mode = $this->mode();
        if ($this->visibility != 'public') {
            if ($mode == 'edit' && !$actor->hasPermission($this->updatePermission())) {
                $mode = 'view';
            }
            if ($mode == 'view' && !$actor->hasPermission($this->readPermission())) {
                $mode = null;
            }
            if ($item && !Service::workflow()->can($actor, $mode, $item)) {
                $mode == null;
            }
            if (!$mode) {
                throw new AccessDeniedException('core.error.access.denied');
            }
        }
        return $mode;
    }

    public function visibility()
    {
        if ($this->visibilityTerm === null) {
            $this->visibilityTerm = ORM::find(Term::class, ['concept' => 'core.visibility', 'term' => $this->visibility]);
        }
        return $this->visibilityTerm;
    }

    public function readPermission()
    {
        return $this->read;
    }

    public function updatePermission()
    {
        return $this->update;
    }

    public function header()
    {
        return $this->header;
    }

    public function sidebar()
    {
        return $this->sidebar;
    }

    public function content()
    {
        return $this->content;
    }

    public function footer()
    {
        return $this->footer;
    }

    public function buildState(array $state)
    {
        $state = array_replace_recursive($this->defaultState(), $state);
        $state = parent::buildState($state);
        $state['page'] = $this;
        return $state;
    }

    public function renderView($data, array $state, $forms = null)
    {
        $context = $this->renderContext($data, $state, $forms);
        return Service::view()->renderView($this->template(), $context);
    }

    public function pageContext($data, array $state, $forms = null)
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
        //dump($context);
        return $context;
    }

    private function postedForm($request, $forms)
    {
        foreach ($forms as $id => $form) {
            $name = $form->getName();
            if ($request->request->has($name)) {
                $form->getRoot()->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    return $form->getRoot();
                }
            }
            if ($root = $this->postedForm($request, $form)) {
                return $root;
            }
        }
        return null;
    }

    public function handleRequest(Request $request, $data, array $state, callable $processForm = null, $redirect = null)
    {
        //dump('PAGE : '.$this->element);
        //dump($this);
        //dump($request);
        //dump($data);
        //dump($state);
        $item = null;
        $state = $this->buildState($state);
        $actor = Service::workflow()->actor();
        $state['actor'] = $actor;
        $state['mode'] = $this->pageMode($actor, $item);
        $options = $this->buildOptions($data, $state, []);
        //dump($options);
        //dump('PAGE : BUILD FORMS');
        $forms = $this->content->buildForms($data, $state, $options);
        //dump($forms);
        //dump('PAGE : CHECK POSTED');
        if ($forms && $request->getMethod() == 'POST' && $posted = $this->postedForm($request, $forms)) {
            //dump($posted);
            if (!$redirect) {
                $redirect = $request->attributes->get('_route');
            }
            if ($processForm === null) {
                return Service::redirectPath($redirect);
            }
            return $processForm($request, $posted, $redirect);
        }
        //dump('PAGE : RENDER');
        $context = $this->pageContext($data, $state, $forms);
        //dump($context);
        $response = Service::view()->renderResponse($this->template(), $context);
        //dump($response);
        Service::view()->clearFlashes();
        return $response;
    }

    public function handleJsonRequest(Request $request, $data, array $state, callable $processForm = null)
    {
        $item = null;
        $state = $this->buildState($state);
        $actor = Service::workflow()->actor();
        $state['actor'] = $actor;
        $state['mode'] = $this->pageMode($actor, $item);
        $options = $this->buildOptions($data, $state, []);
        $forms = $this->content->buildForms($data, $state, $options);
        if ($forms && $request->getMethod() == 'POST' && $posted = $this->postedForm($request, $forms)) {
            if (!$redirect) {
                $redirect = $request->attributes->get('_route');
            }
            if ($processForm === null) {
                return Service::redirectPath($redirect);
            }
            return $processForm($request, $posted, $redirect);
        }
        $context = $this->pageContext($data, $state, $forms);
        $response = Service::view()->renderResponse($this->template(), $context);
        Service::view()->clearFlashes();
        return $response;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_page');

        // Fields
        $builder->addStringField('mode', 10);
        $builder->addStringField('visibility', 30);
        $builder->addStringField('template', 100);

        // Associations
        $builder->addPermissionField('read', 'view');
        $builder->addPermissionField('update', 'edit');
        $builder->addManyToOneField('header', Group::class, 'header', 'element');
        $builder->addManyToOneField('sidebar', Group::class, 'sidebar', 'element');
        $builder->addManyToOneField('content', Group::class, 'content', 'element');
        $builder->addManyToOneField('footer', Group::class, 'footer', 'element');
    }
}
