<?php

/**
 * ARK Grid View
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

namespace ARK\View;

use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ClassMetadata;
use ARK\View\Group;

class Grid extends Group
{
    protected $grid = null;

    public function rowCount()
    {
        return count($this->grid());
    }

    public function columnCount($row)
    {
        return count($this->row($row));
    }

    public function cellCount($row, $col)
    {
        return count($this->column($row, $col));
    }

    public function grid()
    {
        if ($this->grid === null) {
            $this->grid = [];
            foreach ($this->cells as $cell) {
                $this->grid[$cell->row()][$cell->col()][$cell->seq()] = $cell;
            }
        }
        return $this->grid;
    }

    public function row($row)
    {
        if ($row < 0 || $row >= count($this->grid())) {
            return [];
        }
        return $this->grid[$row];
    }

    public function column($row, $col)
    {
        if ($row < 0 || $row >= count($this->grid())) {
            return [];
        }
        if ($col < 0 || $col >= count($this->grid[$row])) {
            return [];
        }
        return $this->grid[$row][$col];
    }

    public function columnWidth($row, $col)
    {
        $column = $this->column($row, $col);
        if ($column == []) {
            return null;
        }
        reset($column);
        return current($column)->width();
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        self::groupMetadata($metadata);
    }
}
