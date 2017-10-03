<?php

/**
 * ARK View Group.
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

use Symfony\Component\Form\FormBuilderInterface;

trait GridTrait
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

    public function buildForms(iterable $view) : iterable
    {
        //dump('GRID FORMS : '.$this->id());
        //dump($view);
        $forms = [];
        foreach ($view['children'] as $row) {
            foreach ($row as $col) {
                foreach ($col as $child) {
                    $forms = array_merge($forms, $child['element']->buildForms($child));
                }
            }
        }
        return $forms;
    }

    public function buildForm(iterable $view, FormBuilderInterface $builder) : void
    {
        //dump('BUILD GROUP : '.$this->id());
        //dump($view);
        if ($view['state']['mode'] === 'deny') {
            return;
        }
        if ($view['state']['name']) {
            //dump('GROUP : CELL BUILDER '.$this->name);
            $layoutBuilder = $this->formBuilder($view['state']['name'], $view['data'], $view['options']);
            $builder->add($layoutBuilder);
            foreach ($view['children'] as $row) {
                foreach ($row as $col) {
                    foreach ($col as $child) {
                        $child['element']->buildForm($child, $layoutBuilder);
                    }
                }
            }
        } else {
            $layoutBuilder = $builder;
        }
        foreach ($view['children'] as $row) {
            foreach ($row as $col) {
                foreach ($col as $child) {
                    $child['element']->buildForm($child, $layoutBuilder);
                }
            }
        }
    }

    protected function buildChildren(iterable $view) : iterable
    {
        $children = [];
        foreach ($this->grid() as $rdx => $row) {
            $rowView = [];
            foreach ($row as $cdx => $col) {
                $colView = [];
                foreach ($col as $seq => $cell) {
                    $cellView = $cell->buildView($view);
                    if ($cellView) {
                        $colView[] = $cellView;
                    }
                }
                if ($colView) {
                    $rowView[] = $colView;
                }
            }
            if ($rowView) {
                $children[] = $rowView;
            }
        }
        return $children;
    }
}
