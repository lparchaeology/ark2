<?php

/**
 * ARK Table View
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
use ARK\Service;
use ARK\View\Element;

class Page extends Element
{
    protected $navbar = null;
    protected $sidebar = null;
    protected $content = null;
    protected $footer = null;

    public function navbar()
    {
        return $this->navbar;
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

    public function defaultOptions($route = null)
    {
        return $options;
    }

    public function defaultContext($route = null)
    {
        $options['data'] = null;
        $options['forms'] = null;
        return $options;
    }

    public function buildForms($mode, $data, $options)
    {
        return $this->content->buildForms($mode, $data, $options);
    }

    public function renderView($mode, $data, array $options = [], $forms = null, $form = null)
    {
        $options = $this->renderContext($mode, $data, $options, $forms, $form);
        return Service::renderView($this->template(), $options);
    }

    protected function renderContext($mode, $data, array $context = [], $forms = null, $form = null)
    {
        $context['page'] = $this;
        $context['layout'] = $this->content();
        $context['mode'] = $mode;
        $context['data'] = $data;
        $context['forms'] = null;
        if ($forms) {
            foreach ($forms as $name => $form) {
                $context['forms'][$name] = $form->createView();
            }
        }
        $context['form'] = $form;
        return $context;
    }

    public function postedForm($request, $forms)
    {
        if ($forms && $request->getMethod() == 'POST') {
            foreach ($forms as $name => $form) {
                if ($request->request->has($name)) {
                    $form->handleRequest($request);
                    if ($form->isSubmitted() && $form->isValid()) {
                        return $form;
                    }
                    break;
                }
            }
        }
        return null;
    }

    public function renderResponse($mode, $data, array $context = [], $forms = null, $form = null)
    {
        $context = $this->renderContext($mode, $data, $context, $forms, $form);
        return Service::renderResponse($this->template(), $context);
    }

    public function handleRequest($request, $mode, $data, $options = [], $context = [], callable $processForm = null, $redirect = null)
    {
        $forms = $this->buildForms($mode, $data, $options);
        if ($posted = $this->postedForm($request, $forms)) {
            if (!$redirect) {
                $redirect = $request->attributes->get('_route');
            }
            if ($processForm === null) {
                return Service::redirectPath($redirect);
            }
            return $processForm($request, $posted, $redirect);
        }
        return $this->renderResponse($mode, $data, $context, $forms);
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_page');

        // Fields
        $builder->addStringField('mode', 10, 'mode');

        // Associations
        $builder->addManyToOneField('navbar', Nav::class, 'navbar', 'element');
        $builder->addManyToOneField('sidebar', Nav::class, 'sidebar', 'element');
        $builder->addManyToOneField('content', Layout::class, 'content', 'element');
        $builder->addManyToOneField('footer', Nav::class, 'footer', 'element');
    }
}
