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
use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Element;
use Doctrine\Common\Collections\ArrayCollection;

class Route
{
    protected $route = '';
    protected $collection = '';
    protected $get = false;
    protected $post = false;
    protected $view;
    protected $redirect;
    protected $controller;
    protected $paths;
    protected $pathIndex;

    public function __construct()
    {
        $this->paths = new ArrayCollection();
    }

    public function id() : string
    {
        return $this->route;
    }

    public function pattern($language = null) : string
    {
        if ($this->pathIndex === null) {
            foreach ($this->paths as $path) {
                $this->pathIndex[$path->language()->code()] = $path->pattern();
            }
        }
        if ($language instanceof Language) {
            return $this->pathIndex[$language->language];
        }
        return $this->pathIndex[$language] ?? $this->pathIndex[Service::locale()] ?? $this->paths[0]->pattern() ?? '';
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

    public function view() : ?Element
    {
        return $this->view;
    }

    public function redirect() : ?self
    {
        return $this->redirect;
    }

    public function controller() : string
    {
        return $this->controller;
    }

    public static function find(string $concept) : ?self
    {
        return ORM::find(self::class, $concept);
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_route');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('route', 30);

        // Fields
        $builder->addStringField('collection', 30);
        $builder->addMappedField('can_get', 'get', 'boolean');
        $builder->addMappedField('can_post', 'post', 'boolean');
        $builder->addStringField('controller', 100);

        // Associations
        $builder->addManyToOneField('view', Element::class, 'view', 'element');
        $builder->addManyToOneField('redirect', self::class, 'redirect', 'route');
        $builder->addOneToManyField('paths', Path::class, 'route');
    }
}
