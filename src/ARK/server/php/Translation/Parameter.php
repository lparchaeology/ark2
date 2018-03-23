<?php

/**
 * ARK Translation Parameter Entity.
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
 * Translation Parameter Entity.
 */
class Parameter
{
    use OrmTrait;

    protected $keyword;
    protected $parameter = '';

    /**
     * Construct a new Parameter entity.
     *
     * @param Keyword $keyword The translation keyword
     * @param string  $name    The parameter name
     */
    public function __construct(Keyword $keyword, string $name)
    {
        $this->keyword = $keyword;
        $this->parameter = $name;
    }

    /**
     * Returns the translation keyword.
     *
     * @return Keyword The translation keyword
     */
    public function keyword() : Keyword
    {
        return $this->keyword;
    }

    /**
     * Returns the translation parameter name.
     *
     * @return string The parameter name
     */
    public function name() : string
    {
        return $this->parameter;
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
                'fields' => ['keyword', 'parameter'],
                'em' => 'config',
            ])
        );
        $metadata->addPropertyConstraints('keyword', [
            new Type('object'),
            new Valid(),
            new NotNull(),
        ]);
        $metadata->addPropertyConstraints('parameter', [
            new Type('string'),
            new NotBlank(),
            new Length(['max' => 30]),
            new Regex('/^[a-z]$/us'),
        ]);
    }

    /**
     * Load Entity ORM Metadata.
     *
     * @param ClassMetadata $metadata The Doctrine ORM metadata object
     */
    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_translation_parameter');
        $builder->addManyToOneKey('keyword', Keyword::class, 'keyword', 'keyword', 'parameters');
        $builder->addStringKey('parameter', 30);
    }
}
