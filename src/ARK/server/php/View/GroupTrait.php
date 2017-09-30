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

trait GroupTrait
{
    public function buildForms(iterable $view) : iterable
    {
        //dump('GROUP FORMS : '.$this->id());
        //dump($view);
        $forms = [];
        foreach ($this->cells() as $cell) {
            $forms = array_merge($forms, $cell->buildForms($view));
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
            $layoutBuilder = $this->formBuilder([$this->name => $data], $state, $options);
            $builder->add($layoutBuilder);
            foreach ($this->cells() as $cell) {
                $cell->buildForm($layoutBuilder, $data, $state, $options);
            }
        } else {
            foreach ($this->cells() as $cell) {
                $cell->buildForm($view);
            }
        }
    }
}
