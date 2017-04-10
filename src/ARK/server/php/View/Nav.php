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
use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Bus\NavAddMessage;
use ARK\View\Element;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Tree\Entity\Repository\ClosureTreeRepository;

class Nav extends Element
{
    protected $parent = null;
    protected $level = 0;
    protected $seq = 0;
    protected $icon = '';
    protected $route = '';
    protected $uri = '';
    protected $seperator = false;
    protected $children = null;

    public function __construct($element, $parent = null, $seq = 0, $separator = false, $route = null, $uri = null, $icon = null)
    {
        parent::__construct($element, 'nav');
        $this->parent = (is_string($parent) ? ORM::find(Nav::class, $parent) : $parent);
        $this->seq = $seq;
        $this->separator = $separator;
        $this->route = $route;
        $this->uri = $uri;
        $this->icon = $icon;
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

    public function sequence()
    {
        return $this->seq;
    }

    public function icon()
    {
        return $this->icon;
    }

    public function route()
    {
        return $this->route;
    }

    public function uri()
    {
        if ($this->route) {
            return Service::path($this->route);
        }
        return $this->uri;
    }

    public function isSeperator()
    {
        return $this->seperator;
    }

    public function renderView($data, $forms = null, $form = null, array $options = [])
    {
        $options['nav'] = $this;
        $options['data'] = $data;
        return Service::renderView($this->template(), $options);
    }

    public static function fromMessage(NavAddMessage $msg)
    {
        return new Nav($msg->nav(), $msg->parent(), $msg->sequence(), $msg->separator(), $msg->route(), $msg->uri(), $msg->icon());
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_nav');
        $builder->setCustomRepositoryClass(ClosureTreeRepository::class);

        $builder->addField('seq', 'integer');
        $builder->addField('level', 'integer');
        $builder->addStringField('icon', 50);
        $builder->addStringField('route', 50);
        $builder->addStringField('uri', 50);
        $builder->addField('seperator', 'boolean');

        $builder->addManyToOneField('parent', Nav::class, 'parent', 'element', true, 'children');
        $builder->addOneToMany('children', Nav::class, 'parent');
    }

    public static function readExtendedMetadata(array &$config)
    {
        $config['strategy'] = 'closure';
        $config['closure'] = 'ARK\View\Tree';
        $config['parent'] = 'parent';
        $config['sortByField'] = 'seq';
        $config['level'] = 'level';
    }
}
