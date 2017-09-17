<?php

/**
 * ARK Translation Domain Entity.
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

namespace ARK\Translation;

use ARK\ORM\ClassMetadataBuilder;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\ClassMetadata;

class Message
{
    protected $language;
    protected $key;
    protected $role;
    protected $text = '';
    protected $notes = '';

    public function __construct(Translation $key, Language $language, Role $role = null)
    {
        $this->key = $key;
        $this->language = $language;
        if (!$role) {
            $role = new Role();
        }
        $this->role = $role;
    }

    public function keyword() : string
    {
        return $this->key->keyword();
    }

    public function domain() : Domain
    {
        return $this->key->domain();
    }

    public function language() : Language
    {
        return $this->language;
    }

    // FIXME Need getXxx to be used as Criteria
    public function getLanguage() : Language
    {
        return $this->language;
    }

    // FIXME Need getXxx to be used as Criteria
    public function getRole() : Role
    {
        return $this->role;
    }

    public function role() : Role
    {
        return $this->role;
    }

    public function text() : string
    {
        return $this->text;
    }

    public function setText(string $text) : void
    {
        $this->text = $text;
    }

    public function notes() : string
    {
        return $this->notes;
    }

    public function setNotes(string $notes) : void
    {
        $this->notes = $notes;
    }

    public function isPlural() : bool
    {
        return $this->key->isPlural();
    }

    public function hasParameters() : bool
    {
        return $this->key->hasParameters();
    }

    public function parameters() : Collection
    {
        return $this->key->parameters();
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_translation_message');
        $builder->addManyToOneKey('language', Language::class);
        $builder->addManyToOneKey('key', Translation::class, 'keyword');
        $builder->addManyToOneKey('role', Role::class);
        $builder->addStringField('text', 4294967295);
        $builder->addStringField('notes', 4294967295);
    }
}
