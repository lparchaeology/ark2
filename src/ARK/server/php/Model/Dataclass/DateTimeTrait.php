<?php

/**
 * ARK Model DateTime Dataclass Trait.
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

namespace ARK\Model\Dataclass;

use ARK\Model\Fragment\Fragment;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Vocabulary\Concept;
use Doctrine\Common\Collections\Collection;

trait DateTimeTrait
{
    protected $pattern = '';
    protected $unicode = '';
    protected $php = '';

    public function pattern() : string
    {
        return $this->pattern;
    }

    public function unicode() : string
    {
        return $this->unicode;
    }

    public function php() : string
    {
        return $this->php;
    }

    public static function buildDateTimeMetadata(ClassMetadataBuilder $builder) : void
    {
        $builder->addStringField('pattern', 255);
        $builder->addStringField('unicode', 50);
        $builder->addStringField('php', 50);
    }

    protected function fragmentValue($fragment, Collection $properties = null)
    {
        if ($fragment instanceof Collection) {
            $fragment = $fragment->first();
        }
        return $fragment->value();
    }

    protected function hydrateFragment($data, Fragment $fragment, Concept $vocabulary = null) : void
    {
        if ($this->isSpan() || $fragment->isSpan()) {
            $fragment->setSpan($data[0], $data[1]);
        } else {
            $fragment->setValue($data);
        }
    }
}
