<?php

/**
 * ARK ORM Item Persister.
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

namespace ARK\Model\Fragment;

use ARK\Model\Attribute;
use ARK\Model\Schema\Schema;
use ARK\Service;

trait ItemFragmentTrait
{
    public function findProperties(string $id, Schema $schema, string $type)
    {
        $attributes = $schema->attributes($type);
        foreach ($attributes as $attribute) {
            $properties[$attribute->name()] = null;
            $attribs[$attribute->name()] = $attribute;
        }
        $frags = $this->getItemFragments($schema->module()->id(), $id);
        $members = [];
        foreach ($frags as $key => $frag) {
            if ($frag['structure'] !== null) {
                $members[$frag['structure']][] = $frag;
                unset($frags[$key]);
            }
        }
        $properties = [];
        foreach ($frags as $frag) {
            $attributeId = $frag['attribute'];
            $attribute = $attribs[$frag['attribute']];
            $value = $this->buildAttributeValue($attribute, $frag, $members);
            if ($attribute->hasMultipleOccurrences()) {
                $properties[$attributeId][] = $value;
            } else {
                $properties[$attributeId] = $value;
            }
        }
        return $properties;
    }

    // TODO Move to ORM persister
    protected function getItemFragments(string $module, string $item)
    {
        $sql = '';
        $tables = Service::database()->getFragmentTables();
        foreach ($tables as $table) {
            if ($sql) {
                $sql .= '
                    UNION ALL
                ';
            }
            $sql .= "
                SELECT *
                FROM $table
                WHERE module = :module
                AND item = :item
            ";
        }
        $params = [
            ':module' => $module,
            ':item' => $item,
        ];
        return $this->conn->fetchAll($sql, $params);
    }

    private function buildAttributeValue(Attribute $attribute, $frag, iterable $members)
    {
        if ($attribute->format()->hasAttributes()) {
            foreach ($attribute->format()->attributes() as $attr) {
                $properties[$attr->name()] = null;
                $attributes[$attr->name()] = $attr;
            }
            if ($attribute->format()->dataclass()->isStructure()) {
                foreach ($members[$frag['fid']] as $member) {
                    if (isset($member['structure']) && $member['structure'] === $frag['fid']) {
                        $attributeId = $member['attribute'];
                        $attr = $attributes[$attributeId];
                        $value = $this->buildAttributeValue($attr, $member, $members);
                        if ($attr->hasMultipleOccurrences()) {
                            $properties[$attributeId][] = $value;
                        } else {
                            $properties[$attributeId] = $value;
                        }
                    }
                }
                return $properties;
            }
            foreach ($attribute->format()->attributes() as $attr) {
                $properties[$attr->name()] = ($attr->isRoot() ? $frag['value'] : $frag['parameter']);
            }
        } else {
            return $frag['value'];
        }
    }
}
