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
use Doctrine\Common\Collections\ArrayCollection;

class Nav extends Element
{
    protected $parent = null;
    protected $children = null;
    protected $level = 0;
    protected $icon = '';
    protected $route = '';
    protected $uri = '';
    protected $seperator = false;

    public function __construct()
    {
        parent::__construct();
        $this->children = new ArrayCollection();
    }

    public function parent()
    {
        return $this->parent;
    }

    public function children()
    {
        return $this->children;
    }

    public function hasChildren()
    {
        return $this->children && $this->children->count() > 0;
    }

    public function level()
    {
        return $this->level;
    }

    public function icon()
    {
        return $this->icon;
    }

    public function uri()
    {
        if ($this->route) {
            return $this->route;
            return Service::path($this->route);
        }
        return $this->uri;
    }

    public function isSeperator()
    {
        return $this->seperator;
    }

    public function renderView($data, $forms = null, $form = null, Cell $cell = null, array $options = [])
    {
        $options['nav'] = $this;
        $options['data'] = $data;
        return Service::renderView($this->template(), $options);
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_nav');
        $builder->setCustomRepositoryClass('Gedmo\Tree\Entity\Repository\ClosureTreeRepository');

        $builder->addField('seperator', 'boolean');

        $builder->addManyToOneField('parent', Nav::class, 'parent', 'element', true, 'children');
        $builder->addOneToMany('children', Nav::class, 'parent');
    }

    public static function readExtendedMetadata(array &$config)
    {
        $config['type'] = 'closure';
        $config['closure'] = 'ARK\View\Tree';
        $config['parent'] = 'parent';
        //$config['level'] = 'level';
    }
}
