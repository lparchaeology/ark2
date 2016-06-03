<?php

/**
 * ARK Object Trait
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

namespace ARK;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

trait ObjectTrait
{
    protected $id = null;
    protected $keyword = null;
    protected $enabled = true;
    protected $deprecated = false;
    protected $valid = false;

    protected function initObject($id, $keyword = null, $enabled = true, $deprecated = false)
    {
        $this->id = $id;
        $this->keyword = $keyword;
        $this->enabled = $enabled;
        $this->deprecated = $deprecated;
    }

    public function id()
    {
        return $this->id;
    }

    public function keyword()
    {
        return $this->keyword;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function isDeprecated()
    {
        return $this->deprecated;
    }

    public function isValid()
    {
        return $this->valid;
    }

    public static function buildMetadata(ClassMetadataBuilder $builder)
    {
        $builder->createField('id', 'integer')->isPrimaryKey()->generatedValue()->build();
        $builder->addField('keyword', 'string', 100);
        $builder->addField('enabled', 'boolean');
        $builder->addField('deprecated', 'boolean');
    }
}
