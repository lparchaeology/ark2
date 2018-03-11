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

use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\Orm;
use ARK\ORM\OrmTrait;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Mapping\ClassMetadata as ValidatorMetadata;

class Message
{
    use OrmTrait;

    protected $language;
    protected $keyword;
    protected $role;
    protected $text = '';
    protected $notes = '';

    public function __construct(Keyword $keyword, Language $language, Role $role = null)
    {
        $this->keyword = $keyword;
        $this->language = $language;
        if (!$role) {
            $role = new Role();
        }
        $this->role = $role;
    }

    public function id() : string
    {
        return [
            'keyword' => $this->keyword->id(),
            'language' => $this->language->code(),
            'role' => $this->role->id(),
        ];
    }

    public function keyword() : string
    {
        return $this->keyword;
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

    public function domain() : Domain
    {
        return $this->keyword->domain();
    }

    public function isPlural() : bool
    {
        return $this->keyword->isPlural();
    }

    public function hasParameters() : bool
    {
        return $this->keyword->hasParameters();
    }

    public function parameters() : Collection
    {
        return $this->keyword->parameters();
    }

    public static function find($keyword, $language, $role = 'default') : ?self
    {
        if ($keyword instanceof Keyword) {
            $keyword = $keyword->id();
        }
        if ($language instanceof Language) {
            $language = $language->code();
        }
        if ($role instanceof Role) {
            $role = $role->id();
        }
        return ORM::find(self::class, ['keyword' => $keyword, 'language' => $language, 'role' => $role]);
    }

    public static function loadValidatorMetadata(ValidatorMetadata $metadata) : void
    {
        $metadata->addConstraint(
            new UniqueEntity([
                'fields' => ['language', 'keyword', 'role'],
                'em' => 'core',
            ])
        );
        $metadata->addPropertyConstraints('language', [
            new Type('object'),
            new Valid(),
            new NotNull(),
        ]);
        $metadata->addPropertyConstraints('keyword', [
            new Type('object'),
            new Valid(),
            new NotNull(),
        ]);
        $metadata->addPropertyConstraints('role', [
            new Type('object'),
            new Valid(),
            new NotNull(),
        ]);
        $metadata->addPropertyConstraints('text', [
            new Type('string'),
            new NotBlank(),
        ]);
        $metadata->addPropertyConstraints('notes', [
            new Type('string'),
            new NotBlank(),
        ]);
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_translation_message');

        // Key
        $builder->addManyToOneKey('language', Language::class);
        $builder->addManyToOneKey('keyword', Keyword::class);
        $builder->addManyToOneKey('role', Role::class);

        // Fields
        $builder->addStringField('text', 4294967295);
        $builder->addStringField('notes', 4294967295);
    }
}
