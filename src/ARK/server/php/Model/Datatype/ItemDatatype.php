<?php

/**
 * ARK Model Item Datatype
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

namespace ARK\Model\Datatype;

use ARK\Model\Datatype;
use ARK\Model\Module;
use ARK\Model\Fragment;
use ARK\Model\Item;
use ARK\Model\LocalText;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Vocabulary\Vocabulary;
use Doctrine\Common\Collections\ArrayCollection;

class ItemDatatype extends Datatype
{
    protected $module = null;

    public function module()
    {
        return $this->module;
    }

    public function defaultValue()
    {
        if ($this->module && $this->preset) {
            $module = ORM::find(Module::class, $this->module);
            return ORM::find($module->classname(), $this->preset);
        }
        // TODO Do we want to return an empty object instead???
        return null;
    }

    protected function fragmentValue($fragment, ArrayCollection $properties = null)
    {
        if ($fragment instanceof ArrayCollection) {
            $fragment = $fragment->first();
        }
        $module = ORM::find(Module::class, $fragment->parameter());
        return ORM::find($module->classname(), $fragment->value());
    }

    protected function hydrateFragment($data, Fragment $fragment, Vocabulary $vocabulary = null)
    {
        if ($data instanceof Item) {
            $fragment->setValue($data->id(), $data->schema()->module()->name());
        } elseif (is_array($data)) {
            $fragment->setValue($data['item'], $data['module']);
        }
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_datatype_item');
        $builder->addStringField('module', 30, 'module', true);
        $builder->addStringField('preset', 30);
    }
}