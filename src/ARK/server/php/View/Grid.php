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

use Symfony\Component\Form\FormFactoryInterface;

class Grid extends Group
{
    public function rowCount()
    {
        return count($this->rows());
    }

    public function columnCount($row)
    {
        return count($this->columns($row));
    }

    public function cellCount($row, $col)
    {
        return count($this->column($row, $col));
    }

    public function rows()
    {
        $this->init();
        return $this->grid;
    }

    public function columns($row)
    {
        if ($row < 0 || $row >= count($this->rows())) {
            return [];
        }
        return $this->grid[$row];
    }

    public function column($row, $col)
    {
        if ($row < 0 || $row >= count($this->rows())) {
            return [];
        }
        if ($col < 0 || $col >= count($this->grid[$col])) {
            return [];
        }
        return $this->grid[$row][$col];
    }

    public function renderForms(FormFactoryInterface $factory, $resource)
    {
        $forms = [];
        foreach ($this->rows() as $rdx => $row) {
            foreach ($row as $cdx => $col) {
                foreach ($col as $cell) {
                    $forms[$rdx][$cdx][] = $cell->renderForms($factory, $resource);
                }
            }
        }
        return $forms;
    }
}
