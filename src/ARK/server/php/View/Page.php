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
use ARK\View\Element;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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

    public function mode(Actor $actor, $item = null)
    {
        // TODO Move check to Security or Workflow???
        if ($this->visibility == 'restricted') {
            if ($actor && $item) {
                if ($this->defaultMode() == 'edit' && Service::workflow()->can($actor, 'edit', $item)) {
                    return 'edit';
                } elseif (Service::workflow()->can($actor, 'view', $item)) {
                    return 'view';
                }
            } elseif ($actor) {
                if ($this->defaultMode() == 'edit' && $this->updatePermission() && Service::workflow()->hasPermission($this->updatePermission(), $actor)) {
                    return 'edit';
                } elseif ($this->readPermission() && Service::workflow()->hasPermission($this->readPermission(), $actor)) {
                    return 'view';
                }
            }
            throw new AccessDeniedException('core.error.access.denied');
        }
        // TODO Assumes visibility == 'public'
        return $this->defaultMode();
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

    public function buildForms($data, $options)
    {
        //dump('BUILD PAGE : '.$this->element);
        //dump($data);
        //dump($options);
        $options = $this->buildOptions($data, $options);
        return $this->content->buildForms($data, $options);
    }

    public function renderView($data, array $state, $forms = null, $form = null)
    {
        $context = $this->renderContext($data, $state, $forms, $form);
        return Service::view()->renderView($this->template(), $context);
    }

    public function renderContext($data, array $context, $forms = null, $form = null)
    {
        $context = $this->viewContext($data, $context, $context['state']);
        $context['page'] = $this;
        $context['layout'] = $this->content();
        $context['forms'] = null;
        if ($forms) {
            foreach ($forms as $name => $form) {
                $context['forms'][$name] = $form->createView();
            }
        }
        $context['form'] = $form;
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

    public function renderResponse($data, array $context, $forms = null, $form = null)
    {
        $context = $this->renderContext($data, $context, $forms, $form);
        return Service::view()->renderResponse($this->template(), $context);
    }

    public function handleRequest($request, $data, $state, callable $processForm = null, $redirect = null)
    {
        //dump($this);
        //dump($request);
        //dump($data);
        //dump($state);
        $actor = Service::workflow()->actor();
        $item = null;
        $state['mode'] = $this->mode($actor, $item);
        $options['state'] = $state;
        $forms = $this->buildForms($data, $options);
        //dump($actor);
        //dump($item);
        //dump($request);
        //dump($request->request);
        //dump($forms);
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
        $context['state'] = $state;
        $response = $this->renderResponse($data, $context, $forms);
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
        $builder->addManyToOneField('header', Layout::class, 'header', 'element');
        $builder->addManyToOneField('sidebar', Layout::class, 'sidebar', 'element');
        $builder->addManyToOneField('content', Layout::class, 'content', 'element');
        $builder->addManyToOneField('footer', Layout::class, 'footer', 'element');
    }
}
