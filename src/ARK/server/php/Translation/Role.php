<?php

/**
 * ARK Translation Role Entity.
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

use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\OrmTrait;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Mapping\ClassMetadata as ValidatorMetadata;

/**
 * Translation Role Entity.
 */
class Role
{
    use KeywordTrait;
    use OrmTrait;

    protected $role = '';

    /**
     * Construct a new translation role entity.
     *
     * @param string $id The role ID
     */
    public function __construct(string $id = 'default')
    {
        $this->role = $id;
    }

    /**
     * Returns the ID of the translation role.
     *
     * @return string The role ID
     */
    public function id() : string
    {
        return $this->role;
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
                'fields' => 'role',
                'em' => 'config',
            ])
        );
        $metadata->addPropertyConstraints('role', [
            new Type('string'),
            new NotBlank(),
            new Length(['max' => 30]),
            new Regex('/^[a-z]$/us'),
        ]);
        $metadata->addPropertyConstraints('keyword', [
            new Type('object'),
            new Valid(),
            new NotNull(),
        ]);
    }

    /**
     * Load Entity ORM Metadata.
     *
     * @param ClassMetadata $metadata The Doctrine ORM metadata object
     */
    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_translation_role');
        $builder->addStringKey('role', 30);
        KeywordTrait::buildKeywordMetadata($builder);
    }
}
