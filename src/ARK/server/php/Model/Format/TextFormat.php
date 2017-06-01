<?php

/**
 * ARK Model Text Format
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

namespace ARK\Model\Format;

use ARK\Model\Fragment;
use ARK\Model\Format;
use ARK\Model\LocalText;
use ARK\Model\Attribute;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Vocabulary\Vocabulary;
use Doctrine\Common\Collections\ArrayCollection;

class TextFormat extends Format
{
    protected $mediatype = '';
    protected $minimumLength = 0;
    protected $maximumLength = 0;
    protected $defaultSize = 0;

    public function mediatype()
    {
        return $this->mediatype;
    }

    public function minimumLength()
    {
        return $this->minimumLength;
    }

    public function maximumLength()
    {
        return $this->maximumLength;
    }

    public function defaultSize()
    {
        return $this->defaultSize;
    }

    protected function fragmentValue($fragment, ArrayCollection $properties = null)
    {
        $data = new LocalText();
        if ($fragment instanceof ArrayCollection) {
            foreach ($fragment as $frag) {
                $data->setContent($frag->value(), $frag->parameter());
                $data->setMediatype($frag->format());
            }
        } elseif ($fragment instanceof Fragment) {
            $data->setContent($fragment->value(), $fragment->parameter());
            $data->setMediatype($fragment->format());
        }
        return $data;
    }

    public function serialize($model, ArrayCollection $properties = null)
    {
        if ($model instanceof Fragment) {
            return [$this->serializeFragment($model, $properties)];
        }
        if (!$model instanceof ArrayCollection || $model->isEmpty()) {
            return null;
        }
        $data = [];
        foreach ($model as $fragment) {
            $data[] = $this->serializeFragment($fragment, $properties);
        }
        return $data;
    }

    protected function serializeFragment(Fragment $fragment, ArrayCollection $properties = null)
    {
        $data[$this->formatName()] = $fragment->format();
        $data[$this->parameterName()] = $fragment->parameter();
        $data[$this->valueName()] = $fragment->value();
        return $data;
    }

    public function hydrate($data, Attribute $attribute, Vocabulary $vocabulary = null)
    {
        $fragments = new ArrayCollection();
        if ($data === [] || $data === null) {
            return $fragments;
        }
        if ($data instanceof LocalText) {
            foreach ($data->contents() as $language => $content) {
                $fragment = Fragment::createFromAttribute($attribute);
                $fragment->setValue($content, $language, $data->mediatype());
                $fragments[] = $fragment;
            }
            return $fragments;
        }
        if (isset($data['content'])) {
            $data = [$data];
        }
        foreach ($data as $datum) {
            $fragment = Fragment::createFromAttribute($attribute);
            $this->hydrateFragment($datum, $fragment, $vocabulary);
            $fragments[] = $fragment;
        }
        return $fragments;
    }

    protected function hydrateFragment($data, Fragment $fragment, Vocabulary $vocabulary = null)
    {
        $fragment->setValue($data['content'], data['language'], content['mediatype']);
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_format_text');

        // Attributes
        $builder->addStringField('mediatype', 30);
        $builder->addField('minimumLength', 'integer', [], 'min_length');
        $builder->addField('maximumLength', 'integer', [], 'max_length');
        $builder->addField('defaultSize', 'integer', [], 'default_size');
        $builder->addStringField('preset', 1431655765);
    }
}
