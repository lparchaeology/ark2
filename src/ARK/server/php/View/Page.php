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
        $options['data'] = null;
        $options['forms'] = null;
        return $options;
    }

    public function buildForms($mode, $data, $options)
    {
        dump('BUILD PAGE '.$this->element.' '.$mode);
        return $this->content->buildForms($mode, $data, $options);
    }

    public function renderView($mode, $data, array $options = [], $forms = null, $form = null)
    {
        $options = $this->renderOptions($mode, $data, $options, $forms, $form);
        return Service::renderView($this->template(), $options);
    }

    public function renderResponse($mode, $data, array $options = [], $forms = null, $form = null)
    {
        $options = $this->renderOptions($mode, $data, $options, $forms, $form);
        return Service::renderResponse($this->template(), $options);
    }

    protected function renderOptions($mode, $data, array $options = [], $forms = null, $form = null)
    {
        $options['page'] = $this;
        $options['layout'] = $this->content();
        $options['mode'] = $mode;
        $options['data'] = $data;
        $options['forms'] = null;
        if ($forms) {
            foreach ($forms as $name => $form) {
                $options['forms'][$name] = $form->createView();
            }
        }
        $options['form'] = $form;
        return $options;
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
