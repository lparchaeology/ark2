<?php

/**
 * ARK Translation Domain Entity
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

namespace ARK\Translation;

use ARK\ORM\ClassMetadataBuilder;
use ARK\Translation\Translation;
use ARK\Translation\Language;
use ARK\Translation\Role;
use Doctrine\ORM\Mapping\ClassMetadata;

class Message
{
    protected $language = null;
    protected $parent = null;
    protected $role = null;
    protected $keyword = '';
    protected $text = '';
    protected $notes = '';

    public function __construct(Translation $parent, Language $language, Role $role = null)
    {
        $this->parent = $parent;
        $this->language = $language;
        if (!$role) {
            $role = new Role();
        }
        $this->role = $role;
    }

    public function keyword()
    {
        return $this->parent->keyword();
    }

    public function domain()
    {
        return $this->parent->domain();
    }

    public function language()
    {
        return $this->language;
    }

    public function role()
    {
        return $this->role;
    }

    public function text()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function notes()
    {
        return $this->notes;
    }

    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    public function isPlural()
    {
        return $this->key->isPlural();
    }

    public function hasParameters()
    {
        return $this->key->hasParameters();
    }

    public function parameters()
    {
        return $this->key->parameters();
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_translation_message');
        $builder->addManyToOneKey('language', 'ARK\Translation\Language');
        $builder->addManyToOneKey('parent', 'ARK\Translation\Translation', 'keyword');
        $builder->addManyToOneKey('role', 'ARK\Translation\Role');
        $builder->addStringField('keyword', 100);
        $builder->addStringField('text', 4294967295);
        $builder->addStringField('notes', 4294967295);
    }
}
