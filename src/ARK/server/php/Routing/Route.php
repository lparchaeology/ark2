<?php

/**
 * ARK Route.
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

namespace ARK\Routing;

use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\View\Page;

class Route
{
    protected $route = '';
    protected $path = '';
    protected $get = false;
    protected $post = false;
    protected $page;
    protected $redirect;
    protected $controller;

    public function id() : string
    {
        return $this->route;
    }

    public function pattern() : string
    {
        return $this->path;
    }

    public function canGet() : bool
    {
        return $this->get;
    }

    public function canPost() : bool
    {
        return $this->post;
    }

    public function method() : string
    {
        if ($this->get && $this->post) {
            return 'GET|POST';
        } elseif ($this->post) {
            return 'POST';
        }
        return 'GET';
    }

    public function page() : ?Page
    {
        return $this->page;
    }

    public function redirect() : ?Route
    {
        return $this->redirect;
    }

    public function controller() : string
    {
        return $this->controller;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_route');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('route', 30);

        // Fields
        $builder->addStringField('path', 10);
        $builder->addField('get', 'boolean', [], 'can_get');
        $builder->addField('post', 'boolean', [], 'can_post');
        $builder->addStringField('controller', 100);

        // Associations
        $builder->addManyToOneField('page', Page::class, 'page', 'element');
        $builder->addManyToOneField('redirect', self::class, 'redirect', 'route');
    }
}
