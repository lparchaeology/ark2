<?php

/**
 * ARK Vocabulary Term.
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

namespace ARK\Vocabulary;

use ARK\Model\EnabledTrait;
use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Term
{
    use EnabledTrait;
    use KeywordTrait;

    protected $concept;
    protected $term;
    protected $alias;
    protected $namespace;
    protected $entity;
    protected $default = false;
    protected $root = false;
    protected $parameters;
    protected $related;
    protected $descendents;

    public function __construct()
    {
        $this->parameters = new ArrayCollection();
        $this->related = new ArrayCollection();
    }

    public function id() : iterable
    {
        return [
            'concept' => $this->concept()->id(),
            'term' => $this->term,
        ];
    }

    public function concept() : Concept
    {
        return $this->concept;
    }

    public function name() : string
    {
        return $this->term;
    }

    public function alias() : ?string
    {
        return $this->alias;
    }

    public function namespace() : string
    {
        return $this->namespace;
    }

    public function entity() : string
    {
        return $this->entity;
    }

    public function classname() : string
    {
        return $this->namespace.'\\'.$this->entity;
    }

    public function isDefault() : bool
    {
        return $this->default;
    }

    public function isRoot() : bool
    {
        return $this->root;
    }

    public function parameters() : Collection
    {
        return $this->parameters;
    }

    public function parameter(string $name) : ?Parameter
    {
        foreach ($this->parameters as $parameter) {
            if ($parameter->name() === $name) {
                return $parameter;
            }
        }
        return null;
    }

    public function related() : Collection
    {
        return $this->related;
    }

    public function descendents(bool $all = false) : Collection
    {
        if ($this->descendents === null) {
            $this->descendents = new ArrayCollection();
            foreach ($this->related as $related) {
                if ($related->fromTerm()->name() !== $related->toTerm()->name() && $related->relation()->id() === 'broader') {
                    if ($related->toTerm()->isEnabled() || $all) {
                        $this->descendents->add($related->toTerm());
                    }
                }
            }
        }
        return $this->descendents;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_vocabulary_term');
        $builder->setReadOnly();

        // Key
        $builder->addVocabularyKey('concept', 'concept', 'terms');
        $builder->addStringKey('term', 30);

        // Attributes
        $builder->addStringField('alias', 10);
        $builder->addStringField('namespace', 50);
        $builder->addStringField('entity', 30);
        $builder->addMappedField('is_default', 'default', 'boolean');
        $builder->addField('root', 'boolean');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Associations
        $builder->addOneToManyField('parameters', Parameter::class, 'term');
        $builder->addOneToManyField('related', Related::class, 'fromTerm');
    }
}
