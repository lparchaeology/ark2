<?php

/**
 * ARK Model Taxonomy Vocabulary
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

namespace ARK\Vocabulary;

use Doctrine\ORM\Mapping\ClassMetadata;

class Taxonomy extends Vocabulary
{
    protected $taxons = null;

    public function taxons()
    {
        if (!$this->taxons) {
            foreach ($this->terms() as $term) {
                foreach ($term->related() as $related) {
                    if ($related->depth() == 1) {
                        $this->taxons[] = $term;
                    }
                }
            }
        }
        return $this->taxons;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
    }
}
