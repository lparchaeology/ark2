<?php

/**
 * ARK Grid View.
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

namespace ARK\View;

use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;

class Grid extends Group
{
    protected $grid;

    public function rowCount() : int
    {
        return count($this->grid());
    }

    public function columnCount(int $row) : int
    {
        return count($this->row($row));
    }

    public function cellCount(int $row, int $col) : int
    {
        return count($this->column($row, $col));
    }

    public function grid() : iterable
    {
        if ($this->grid === null) {
            $this->grid = [];
            foreach ($this->cells as $cell) {
                $this->grid[$cell->row()][$cell->col()][$cell->seq()] = $cell;
            }
        }
        return $this->grid;
    }

    public function row(int $row) : iterable
    {
        if ($row < 0 || $row >= count($this->grid())) {
            return [];
        }
        return $this->grid[$row];
    }

    public function column(int $row, int $col) : iterable
    {
        if ($row < 0 || $row >= count($this->grid())) {
            return [];
        }
        if ($col < 0 || $col >= count($this->grid[$row])) {
            return [];
        }
        return $this->grid[$row][$col];
    }

    public function columnWidth(int $row, int $col) : ?int
    {
        $column = $this->column($row, $col);
        if ($column === []) {
            return null;
        }
        reset($column);
        return current($column)->width();
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_group');
        $builder->setReadOnly();

        // Fields
        $builder->addStringField('name', 30);
        $builder->addStringField('mode', 10);
        KeywordTrait::buildKeywordMetadata($builder);
        $builder->addStringField('template', 100);
        $builder->addStringField('formType', 100, 'form_type');

        // Associations
        $builder->addOneToMany('cells', Cell::class, 'group');
    }
}
