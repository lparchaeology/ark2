<?php

/**
 * ARK Model Text Dataclass.
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

namespace ARK\Model\Dataclass;

use ARK\Model\Attribute;
use ARK\Model\Fragment\Fragment;
use ARK\Model\LocalText;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Security\Actor;
use ARK\Vocabulary\Concept;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

class TextDataclass extends Dataclass
{
    protected $mediatype = '';
    protected $minimumLength = 0;
    protected $maximumLength = 0;
    protected $defaultSize = 0;

    public function mediatype() : string
    {
        return $this->mediatype;
    }

    public function minimumLength() : int
    {
        return $this->minimumLength;
    }

    public function maximumLength() : int
    {
        return $this->maximumLength;
    }

    public function defaultSize() : int
    {
        return $this->defaultSize;
    }

    public function emptyValue() : LocalText
    {
        return new LocalText();
    }

    public function constraints() : iterable
    {
        $constraints = parent::constraints();
        $constraints[] = new Type('string');
        $constraints[] = new Length(['min' => $this->minimumLength, 'max' => $this->maximumLength]);
        return $constraints;
    }

    public function serialize($model, Collection $properties = null)
    {
        if ($model instanceof Fragment) {
            return [$this->serializeFragment($model, $properties)];
        }
        if (!$model instanceof Collection || $model->isEmpty()) {
            return null;
        }
        $data = [];
        foreach ($model as $fragment) {
            $data[] = $this->serializeFragment($fragment, $properties);
        }
        return $data;
    }

    public function hydrate(
        $data,
        Attribute $attribute,
        Actor $creator,
        DateTime $created,
        Concept $vocabulary = null
    ) : Collection {
        $fragments = new ArrayCollection();
        if ($data === [] || $data === null) {
            return $fragments;
        }
        if (is_string($data)) {
            $data = new LocalText($data);
        }
        if ($data instanceof LocalText) {
            foreach ($data->contents() as $language => $content) {
                $fragment = Fragment::createFromAttribute($attribute, $creator, $created);
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

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_dataclass_text');

        // Attributes
        $builder->addStringField('mediatype', 30);
        $builder->addMappedField('min_length', 'minimumLength', 'integer');
        $builder->addMappedField('max_length', 'maximumLength', 'integer');
        $builder->addMappedField('default_size', 'defaultSize', 'integer');
        $builder->addStringField('preset', 1431655765);
    }

    protected function fragmentValue($fragment, Collection $properties = null)
    {
        $data = new LocalText();
        if ($fragment instanceof Collection) {
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

    protected function serializeFragment(Fragment $fragment, Collection $properties = null)
    {
        $data[$this->formatName()] = $fragment->format();
        $data[$this->parameterName()] = $fragment->parameter();
        $data[$this->valueName()] = $fragment->value();
        return $data;
    }

    protected function hydrateFragment($data, Fragment $fragment, Concept $vocabulary = null) : void
    {
        $fragment->setValue($data['content'], $data['language'], $data['mediatype']);
    }
}
