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

class Language
{
    protected $language = '';
    protected $markup = true;
    protected $vocabulary = true;
    protected $text = true;

    public function __construct(string $code, bool $markup = true, bool $vocabulary = true, bool $text = true)
    {
        $this->language = $code;
        $this->markup = $markup;
        $this->vocabulary = $vocabulary;
        $this->text = $text;
    }

    public function code() : string
    {
        return $this->language;
    }

    public function usedForMarkup() : bool
    {
        return $this->markup;
    }

    public function usedForVocabulary() : bool
    {
        return $this->vocabulary;
    }

    public function usedForText() : bool
    {
        return $this->text;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_translation_language');
        $builder->addStringKey('language', 10);
        $builder->addField('markup', 'boolean');
        $builder->addField('vocabulary', 'boolean');
        $builder->addField('text', 'boolean');
    }
}
