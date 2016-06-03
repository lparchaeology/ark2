<?php

/**
 * ARK ORM Item Persister
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

namespace ARK\ORM;

use ARK\Schema\Schema;
use ARK\Service;
use Doctrine\ORM\Persisters\Entity\BasicEntityPersister;

class ItemEntityPersister extends BasicEntityPersister
{
    public function loadAttributes($id, Schema $schema, $subtype)
    {
        $properties = $schema->properties();
        foreach ($properties as $prop) {
            $attributes[$prop->name()] = null;
            $props[$prop->name()] = $prop;
        }
        $frags = $this->getItemFragments($schema->module()->name(), $id);
        $members = [];
        foreach ($frags as $key => $frag) {
            if ($frag['object_fid'] !== null) {
                $members[$frag['object_fid']][] = $frag;
                unset($frags[$key]);
            }
        }
        $attributes = [];
        foreach ($frags as $frag) {
            $propertyId = $frag['property'];
            $property = $props[$frag['property']];
            $value = $this->buildAttributeValue($property, $frag, $members);
            if ($property->hasMultipleOccurrences()) {
                $attributes[$propertyId][] = $value;
            } else {
                $attributes[$propertyId] = $value;
            }
        }
        return $attributes;
    }

    private function buildAttributeValue($property, $frag, array $members)
    {
        if ($property->format()->type() == 'object') {
            foreach ($property->properties() as $prop) {
                $attributes[$prop->name()] = null;
                $properties[$prop->name()] = $prop;
            }
            foreach ($members[$frag['fid']] as $member) {
                if (isset($member['object_fid']) && $member['object_fid'] === $frag['fid']) {
                    $propertyId = $member['property'];
                    $prop = $properties[$propertyId];
                    $value = $this->buildAttributeValue($prop, $member, $members);
                    if ($prop->hasMultipleOccurrences()) {
                        $attributes[$propertyId][] = $value;
                    } else {
                        $attributes[$propertyId] = $value;
                    }
                }
            }
            return $attributes;
        } else {
            return $this->buildFrag($frag);
        }
    }

    private function buildFrag($frag)
    {
        if (!empty($frag['parameter'])) {
            return [$frag['parameter'], $frag['value']];
        }
        return $frag['value'];
    }

    protected function getItemFragments($module, $item)
    {
        $sql = '';
        $tables = Service::database()->getFragmentTables();
        foreach ($tables as $table) {
            if ($sql) {
                $sql .= "
                    UNION ALL
                ";
            }
            $sql .= "
                SELECT *
                FROM $table
                WHERE module = :module
                AND item = :item
            ";
        }
        $params = array(
            ':module' => $module,
            ':item' => $item,
        );
        return $this->conn->fetchAll($sql, $params);
    }
}
