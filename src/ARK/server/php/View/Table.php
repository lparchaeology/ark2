<?php

/**
 * ARK View Table
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

namespace ARK\View;

use Symfony\Component\Form\FormFactoryInterface;
use ARK\Database\Database;

class Table extends Layout
{
    protected function __construct(Database $db, /*string*/ $layout)
    {
        parent::__construct($db, $layout);
        $this->template = 'layouts/table.html.twig';
    }

    public function header()
    {
        return $this->optionValue('header', true);
    }

    public function footer()
    {
        return $this->optionValue('footer', false);
    }

    public function striped()
    {
        return $this->optionValue('striped', false);
    }

    public function bordered()
    {
        return $this->optionValue('bordered', false);
    }

    public function hover()
    {
        return $this->optionValue('hover', true);
    }

    public function condensed()
    {
        return $this->optionValue('condensed', false);
    }

    public function responsive()
    {
        return $this->optionValue('responsive', true);
    }

    public function pagination()
    {
        return $this->optionValue('pagination', true);
    }

    public function search()
    {
        return $this->optionValue('search', true);
    }

    public function export()
    {
        return $this->optionValue('export', true);
    }

    public function fields()
    {
        return $this->elements();
    }
}
