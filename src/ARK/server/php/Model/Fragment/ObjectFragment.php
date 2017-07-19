<?php

/**
 * ARK Model Object Fragment.
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
 *
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Model\Fragment;

use ARK\Model\Attribute;
use ARK\Model\Fragment;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Service;

class ObjectFragment extends Fragment
{
    protected $children = null;

    public function __construct()
    {
        // TODO Use ORM Generator properly in metadata??? Or persist does auto?
        $this->fid = Service::database()->data()->generateSequence('object', '', 'fid');
    }

    public function children(Attribute $attribute)
    {
        if ($this->children->isEmpty()) {
            $this->children = new ArrayCollection();
            $key = [
               'module' => $this->module,
               'item' => $this->item,
               'attribute' => $attribute->name(),
               'object' => $this->object->id(),
            ];
            $this->children = ORM::findBy($attribute->datatype()->type()->dataClass(), $key);
        }

        return $this->children;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        return self::buildSubclassMetadata($metadata, self::class);
    }

    public static function buildSubclassMetadata(ClassMetadata $metadata, $class)
    {
        $type = Service::database()->getFragmentType($class);
        $builder = new ClassMetadataBuilder($metadata, $type['data_table']);
        $builder->addKey('fid', 'integer');
        $builder->addStringField('value', $type['storage_size']);
        $builder->addStringField('extent', $type['storage_size']);
    }
}
