<?php

/**
 * ARK Model Abstract Vocabulary
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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\Vocabulary;

use ARK\EnabledTrait;
use ARK\KeywordTrait;
use ARK\ORM\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Common\Collections\Collection;

abstract class Vocabulary
{
    use EnabledTrait;
    use KeywordTrait;

    protected $concept = '';
    protected $type = null;
    protected $source = '';
    protected $closed = true;
    protected $terms = null;

    public function __construct()
    {
        $this->terms = new Collection();
    }

    public function concept()
    {
        return $this->concept;
    }

    public function type()
    {
        return $this->type;
    }

    public function source()
    {
        return $this->source;
    }

    public function closed()
    {
        return $this->closed;
    }

    public function terms()
    {
        return $this->terms;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_vocabulary');
        $builder->addStringKey('concept', 30);
        $builder->addManyToOneField('type', 'Type', 'type', 'type', false);
        $builder->addStringField('source', 30);
        $builder->addField('closed', 'boolean');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);
        $builder->setSingleTableInheritance()->setDiscriminatorColumn('type', 'string', 10);
        $builder->addDiscriminatorMapClass('taxonomy', 'Taxonomy');
        $builder->addDiscriminatorMapClass('list', 'TermList');
        $builder->addDiscriminatorMapClass('ring', 'TermRing');
        $builder->addDiscriminatorMapClass('thesaurus', 'Thesaurus');
        $builder->addOneToMany('terms', 'Term', 'concept');
        $builder->setReadOnly();
    }
}
