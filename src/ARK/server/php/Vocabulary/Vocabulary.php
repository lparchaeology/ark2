<?php

/**
 * ARK Vocabulary.
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

namespace ARK\Vocabulary;

use ARK\ORM\ORM;
use Doctrine\Common\Collections\Collection;

class Vocabulary
{
    public static function find(string $concept) : ?Concept
    {
        return ORM::find(Concept::class, $concept);
    }

    public static function findTerm(string $concept, string $term) : ?Term
    {
        return ORM::findOneBy(Term::class, ['concept' => $concept, 'term' => $term]);
    }

    public static function findTerms(string $concept, iterable $terms) : ?Collection
    {
        return ORM::findBy(Term::class, ['concept' => $concept, 'term' => $terms]);
    }

    public static function findRelated(string $concept) : ?Collection
    {
        return ORM::findBy(Related::class, ['fromConceptName' => $concept]);
    }
}
