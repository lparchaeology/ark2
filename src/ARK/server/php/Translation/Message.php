<?php

/**
 * ARK Translation Message Entity.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
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
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Translation;

use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\Orm;
use ARK\ORM\OrmTrait;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Mapping\ClassMetadata as ValidatorMetadata;

/**
 * Translation Message Entity.
 */
class Message
{
    use OrmTrait;

    protected $language;
    protected $keyword;
    protected $role;
    protected $text = '';
    protected $notes = '';

    /**
     * Construct a new Message entity.
     *
     * @param Keyword  $keyword  The translation keyword
     * @param Language $language The translation language
     * @param Role     $role     The translation role
     */
    public function __construct(Keyword $keyword, Language $language, Role $role = null)
    {
        $this->keyword = $keyword;
        $this->language = $language;
        if (!$role) {
            $role = new Role();
        }
        $this->role = $role;
    }

    /**
     * Returns the ID of the translation message.
     *
     * @return iterable The message ID
     */
    public function id() : iterable
    {
        return [
            'keyword' => $this->keyword->id(),
            'language' => $this->language->code(),
            'role' => $this->role->id(),
        ];
    }

    /**
     * Returns the message keyword.
     *
     * @return Keyword The message keyword
     */
    public function keyword() : Keyword
    {
        return $this->keyword;
    }

    /**
     * Returns the message language.
     *
     * @return Language The message language
     */
    public function language() : Language
    {
        return $this->language;
    }

    // TODO Need getXxx to be used as Criteria, find way around
    public function getLanguage() : Language
    {
        return $this->language;
    }

    // TODO Need getXxx to be used as Criteria, find way around
    public function getRole() : Role
    {
        return $this->role;
    }

    /**
     * Returns the message role.
     *
     * @return Role The message role
     */
    public function role() : Role
    {
        return $this->role;
    }

    /**
     * Returns the message text.
     *
     * @return string The message text
     */
    public function text() : string
    {
        return $this->text;
    }

    /**
     * Set the message text.
     *
     * @param string $text The new message text
     */
    public function setText(string $text) : void
    {
        $this->text = $text;
    }

    /**
     * Returns the message notes.
     *
     * @return string The message notes
     */
    public function notes() : string
    {
        return $this->notes;
    }

    /**
     * Set the message notes.
     *
     * @param string $notes The new message notes
     */
    public function setNotes(string $notes) : void
    {
        $this->notes = $notes;
    }

    /**
     * Query the ORM for a translation message.
     *
     * @param Keyword|string  $keyword  The keyword to to query for
     * @param Language|string $language The langauge to query for
     * @param Role|string     $role     The role to query for
     *
     * @return Message|null The message
     */
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

    /**
     * Load Entity Validator Metadata.
     *
     * @param ValidatorMetadata $metadata The Symfony validator metadata object
     */
    public static function loadValidatorMetadata(ValidatorMetadata $metadata) : void
    {
        $metadata->addConstraint(
            new UniqueEntity([
                'fields' => ['language', 'keyword', 'role'],
                'em' => 'config',
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

    /**
     * Load Entity ORM Metadata.
     *
     * @param ClassMetadata $metadata The Doctrine ORM metadata object
     */
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
