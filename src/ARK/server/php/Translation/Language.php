<?php

/**
 * ARK Translation Language Entity.
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
use Symfony\Component\Validator\Mapping\ClassMetadata as ValidatorMetadata;

/**
 * Translation Language Entity
 */
class Language
{
    use OrmTrait;

    protected $language = '';
    protected $markup = true;
    protected $vocabulary = true;
    protected $text = true;

    /**
     * Construct a new Language Entity
     *
     * @param string  $code       The language code
     * @param boolean $markup     If the language is used for markup
     * @param boolean $vocabulary If the language is used for vocabularies
     * @param boolean $text       If the language is used for text
     */
    public function __construct(string $code, bool $markup = true, bool $vocabulary = true, bool $text = true)
    {
        $this->language = $code;
        $this->markup = $markup;
        $this->vocabulary = $vocabulary;
        $this->text = $text;
    }

    /**
     * Returns the language code
     *
     * @return string The language code
     */
    public function code() : string
    {
        return $this->language;
    }

    /**
     * Returns if the language is used for markup
     *
     * @return bool If the language is used for markup
     */
    public function usedForMarkup() : bool
    {
        return $this->markup;
    }

    /**
     * Returns if the language is used for vocabularies
     *
     * @return bool If the language is used for vocabularies
     */
    public function usedForVocabulary() : bool
    {
        return $this->vocabulary;
    }

    /**
     * Returns if the language is used for text
     *
     * @return bool If the language is used for text
     */
    public function usedForText() : bool
    {
        return $this->text;
    }

    /**
     * Load Entity Validator Metadata
     *
     * @param ValidatorMetadata $metadata The Symfony validator metadata object
     */
    public static function loadValidatorMetadata(ValidatorMetadata $metadata) : void
    {
        $metadata->addConstraint(
            new UniqueEntity([
                'fields' => 'language',
                'em' => 'core',
            ])
        );
        $metadata->addPropertyConstraints('language', [
            new Type('string'),
            new NotBlank(),
            new Length(['max' => 10]),
            new Regex('/^[a-z]$/us'),
        ]);
        $metadata->addPropertyConstraints('markup', [
            new Type('bool'),
            new NotNull(),
        ]);
        $metadata->addPropertyConstraints('vocbulary', [
            new Type('bool'),
            new NotNull(),
        ]);
        $metadata->addPropertyConstraints('text', [
            new Type('bool'),
            new NotNull(),
        ]);
    }

    /**
     * Load Entity ORM Metadata
     *
     * @param ClassMetadata $metadata The Doctrine ORM metadata object
     */
    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_translation_language');
        $builder->addStringKey('language', 10);
        $builder->addField('markup', 'boolean');
        $builder->addField('vocabulary', 'boolean');
        $builder->addField('text', 'boolean');
    }
}
