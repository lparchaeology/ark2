<?php

/**
 * ARK View Tabbed
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

class Tabbed extends Layout
{
    protected function __construct(Database $db, /*string*/ $layout)
    {
        parent::__construct($db, $layout);
        $this->template = 'layouts/tabbed.html.twig';
    }

    public function toggle()
    {
        if (isset($this->options['toggle'])) {
            return $this->options['toggle'];
        }
        return 'tab';
    }

    public function justified()
    {
        if (isset($this->options['justified'])) {
            return $this->options['justified'];
        }
        return false;
    }

    public function fade()
    {
        if (isset($this->options['fade'])) {
            return $this->options['fade'];
        }
        return false;
    }

    public function showSingleTab()
    {
        if (isset($this->options['show_single_tab'])) {
            return $this->options['show_single_tab'];
        }
        return false;
    }

    public function defaultTab()
    {
        if (isset($this->options['default_tab'])) {
            return $this->options['default_tab'];
        }
        return $this->tabs()[0]->id();
    }

    public function tabs()
    {
        return $this->elements();
    }
}
