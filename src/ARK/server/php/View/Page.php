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
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Service;
use ARK\Vocabulary\Term;
use ARK\Workflow\Exception\WorkflowException;
use ARK\Workflow\Permission;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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

    public function buildState($data, iterable $state) : iterable
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

    public function renderView($data, iterable $state, iterable $forms = null) : string
    {
        $context = $this->renderContext($data, $state, $forms);
        return Service::view()->renderView($this->template(), $context);
    }

    public function pageContext($data, iterable $state, iterable $forms = null) : iterable
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

    public function handleRequest(Request $request, $data, iterable $state, callable $processForm = null) : Response
    {
        //dump('PAGE : '.$this->element);
        //dump($this);
        //dump($request);
        //dump($data);
        //dump($state);
        $state = $this->buildState($data, $state);
        //dump($state);
        if ($state['mode'] === 'deny') {
            throw new AccessDeniedException('core.error.access.denied');
        }
        $options = $this->buildOptions($data, $state, []);
        //dump($options);
        $forms = $this->content->buildForms($data, $state, $options);
        //dump($forms);
        if ($forms && $request->getMethod() === 'POST') {
            $parms = $request->request->all();
            $parms = $this->fixStaticFields($parms);
            $request->request->replace($parms);
            try {
                $posted = $this->postedForm($request, $forms);
                if ($posted !== null && $posted->isValid()) {
                    if ($processForm !== null) {
                        $processForm($request, $posted);
                    }
                    $redirect = $request->attributes->get('redirect') ?? $request->attributes->get('_route');
                    $parameters = $request->attributes->get('parameters') ?? [];
                    return Service::redirectPath($redirect, $parameters);
                }
                Service::view()->addErrorFlash('core.error.form.invalid');
                foreach ($posted->getErrors(true) as $error) {
                    Service::view()->addErrorFlash($error->getMessage());
                }
            } catch (WorkflowException $e) {
                Service::view()->addErrorFlash($e->getMessage());
            }
        }
        //dump('PAGE : RENDER');
        //dump($state);
        $context = $this->pageContext($data, $state, $forms);
        //dump($context);
        $response = Service::view()->renderResponse($this->template(), $context);
        //dump($response);
        return $response;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
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

    protected function fixStaticFields(iterable $parms) : iterable
    {
        foreach ($parms as $key => &$value) {
            if (is_iterable($value)) {
                $parms[$key] = $this->fixStaticFields($value);
            }
            if ($key === '_static') {
                $parms['static'] = $value;
            }
        }
        return $parms;
    }

    protected function postedForm(Request $request, iterable $forms)
    {
        foreach ($forms as $id => $form) {
            if ($request->request->has($form->getName())) {
                $form->getRoot()->handleRequest($request);
                if ($form->isSubmitted()) {
                    return $form->getRoot();
                }
                return null;
            }
            if ($root = $this->postedForm($request, $form)) {
                return $root;
            }
        }
        return null;
    }
}
