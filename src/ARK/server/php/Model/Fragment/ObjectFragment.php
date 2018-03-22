<?php

/**
 * ARK Model Object Fragment.
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
 *
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Model\Fragment;

use ARK\Model\Attribute;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Service;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ObjectFragment extends Fragment
{
    protected $children;

    public function __construct()
    {
        // TODO Use ORM Generator properly in metadata??? Or persist does auto?
        $this->fid = Service::database()->data()->generateSequence('object', '', 'fid');
        $this->children = new ArrayCollection();
    }

    public function children(Attribute $attribute) : Collection
    {
        if ($this->children === null || $this->children->isEmpty()) {
            $key = [
               'module' => $this->module,
               'item' => $this->item,
               'attribute' => $attribute->name(),
               'object' => $this->object->id(),
            ];
            $this->children = ORM::findBy($attribute->dataclass()->datatype()->dataClass(), $key);
        }

        return $this->children;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        self::buildSubclassMetadata($metadata, self::class);
    }

    public static function buildSubclassMetadata(ClassMetadata $metadata, string $class) : void
    {
        $datatype = Service::database()->getFragmentDatatype($class);
        $builder = new ClassMetadataBuilder($metadata, $datatype['data_table']);
        $builder->addKey('fid', 'integer');
        $builder->addStringField('value', $datatype['storage_size']);
        $builder->addStringField('extent', $datatype['storage_size']);
    }
}
