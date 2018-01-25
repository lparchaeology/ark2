<?php

/**
 * ARK Model Item Dataclass.
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
use ARK\Model\Item;
use ARK\Model\Schema\Module;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Vocabulary\Concept;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints\Type;

class ItemDataclass extends Dataclass
{
    protected $module;

    public function module() : string
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

    public function constraints() : iterable
    {
        $constraints = parent::constraints();
        if ($this->entity) {
            $constraints[] = new Type($this->entity);
        }
        return $constraints;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_dataclass_item');
        $builder->addMappedStringField('module', 'module', 30, true);
        $builder->addStringField('preset', 30);
    }

    protected function fragmentValue($fragment, Collection $properties = null)
    {
        if ($fragment instanceof Collection) {
            $fragment = $fragment->first();
        }
        return ORM::findItemByModule($fragment->parameter(), $fragment->value());
    }

    protected function hydrateFragment($data, Fragment $fragment, Concept $vocabulary = null) : void
    {
        if ($data instanceof Item) {
            $fragment->setValue($data->id(), $data->schema()->module()->id());
        } elseif (is_array($data)) {
            $fragment->setValue($data['id'], $data['module']);
        }
    }
}
