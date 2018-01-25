<?php

/**
 * ARK Abstract Vocabulary Concept.
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
use Symfony\Component\Workflow\Definition;
use Symfony\Component\Workflow\DefinitionBuilder;
use Symfony\Component\Workflow\Transition;

abstract class Concept
{
    use EnabledTrait;
    use KeywordTrait;

    protected $concept;
    protected $type;
    protected $source;
    protected $namespace;
    protected $entity;
    protected $closed = true;
    protected $transitions = false;
    protected $definition;
    protected $terms;
    protected $enabledTerms;

    public function __construct()
    {
        $this->terms = new ArrayCollection();
    }

    public function id() : string
    {
        return $this->concept;
    }

    public function type() : Type
    {
        return $this->type;
    }

    public function source() : string
    {
        return $this->source;
    }

    public function closed() : bool
    {
        return $this->closed;
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

    public function terms(bool $all = false) : Collection
    {
        if ($all) {
            return $this->terms;
        }
        if ($this->enabledTerms === null) {
            $this->enabledTerms = new ArrayCollection();
            foreach ($this->terms as $term) {
                if ($term->isEnabled()) {
                    $this->enabledTerms->add($term);
                }
            }
        }
        return $this->enabledTerms;
    }

    public function term(string $name) : ?Term
    {
        foreach ($this->terms as $term) {
            if ($term->name() === $name) {
                return $term;
            }
        }
        return null;
    }

    public function defaultTerm() : ?Term
    {
        foreach ($this->terms as $term) {
            if ($term->isDefault()) {
                return $term;
            }
        }
        return null;
    }

    public function hasTransitions() : bool
    {
        return $this->transitions;
    }

    public function transitions() : Definition
    {
        if ($this->hasTransitions() && $this->definition === null) {
            $builder = new DefinitionBuilder();
            foreach ($this->terms() as $term) {
                $builder->addPlace($term->name());
                if ($term->isRoot()) {
                    $builder->setInitialPlace($term->name());
                }
            }
            foreach ($this->terms() as $term) {
                foreach ($term->related() as $related) {
                    if ($related->type() === 'transition') {
                        $trans = new Transition($related->parameter(), $related->fromTerm()->name(), $related->toTerm()->name());
                        $builder > addTransition($trans);
                    }
                }
            }
            $this->definition = $builder->build();
        }
        return $this->definition;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_vocabulary');
        $builder->setReadOnly();
        $builder->setSingleTableInheritance()->setDiscriminatorColumn('type', 'string', 10);
        $builder->addDiscriminatorMapClass('list', TermList::class);
        $builder->addDiscriminatorMapClass('ring', Ring::class);
        $builder->addDiscriminatorMapClass('taxonomy', Taxonomy::class);
        $builder->addDiscriminatorMapClass('thesaurus', Thesaurus::class);

        // Key
        $builder->addStringKey('concept', 30);

        // Attributes
        $builder->addRequiredManyToOneField('type', Type::class);
        $builder->addStringField('source', 30);
        $builder->addStringField('namespace', 50);
        $builder->addStringField('entity', 30);
        $builder->addField('closed', 'boolean');
        $builder->addField('transitions', 'boolean');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Associations
        $builder->addOneToManyField('terms', Term::class, 'concept');
    }
}
