<?php

/**
 * ARK Table View.
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

use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Bus\NavAddMessage;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Tree\Entity\Repository\ClosureTreeRepository;

class Nav extends Element
{
    protected $parent;
    protected $level = 0;
    protected $seq = 0;
    protected $icon = '';
    protected $route = '';
    protected $uri = '';
    protected $seperator = false;
    protected $children;

    public function __construct(
        string $element,
        $parent = null,
        int $seq = 0,
        bool $separator = false,
        string $route = null,
        string $uri = null,
        string $icon = null
    ) {
        parent::__construct($element, 'nav');
        $this->parent = (is_string($parent) ? ORM::find(self::class, $parent) : $parent);
        $this->seq = $seq;
        $this->separator = $separator;
        $this->route = $route;
        $this->uri = $uri;
        $this->icon = $icon;
        $this->children = new ArrayCollection();
    }

    public function parent() : Nav
    {
        return $this->parent;
    }

    public function children() : Collection
    {
        return $this->children;
    }

    public function hasChildren() : bool
    {
        return $this->children && $this->children->count() > 0;
    }

    public function hierarchy() : Collection
    {
        return ORM::repository(self::class)->getChildren($this, false, 'seq');
    }

    public function level() : int
    {
        return $this->level;
    }

    public function sequence() : int
    {
        return $this->seq;
    }

    public function icon() : string
    {
        return $this->icon;
    }

    public function route() : string
    {
        return $this->route;
    }

    public function uri() : string
    {
        if ($this->route) {
            return Service::path($this->route);
        }
        return $this->uri;
    }

    public function isSeperator() : bool
    {
        return $this->seperator;
    }

    public static function fromMessage(NavAddMessage $msg) : Nav
    {
        return new self(
            $msg->nav(),
            $msg->parent(),
            $msg->sequence(),
            $msg->separator(),
            $msg->route(),
            $msg->uri(),
            $msg->icon()
        );
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_nav');
        $builder->setCustomRepositoryClass(ClosureTreeRepository::class);

        $builder->addField('seq', 'integer');
        $builder->addField('level', 'integer');
        $builder->addField('seperator', 'boolean');
        $builder->addStringField('icon', 50);
        $builder->addStringField('route', 50);
        KeywordTrait::buildKeywordMetadata($builder);
        $builder->addStringField('template', 100);
        $builder->addStringField('uri', 2038);

        $builder->addManyToOneField('parent', self::class, 'parent', 'element', true, 'children');
        $builder->addOneToMany('children', self::class, 'parent');
    }

    public static function readExtendedMetadata(iterable &$config) : void
    {
        $config['strategy'] = 'closure';
        $config['closure'] = Tree::class;
        $config['parent'] = 'parent';
        $config['sortByField'] = 'seq';
        $config['level'] = 'level';
    }
}
