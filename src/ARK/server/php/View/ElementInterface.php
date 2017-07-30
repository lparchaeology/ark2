<?php

/**
 * ARK View Cell.
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
use Symfony\Component\Form\FormView;

interface ElementInterface
{
    public function formName() : string;

    public function template() : string;

    public function mode() : string;

    public function buildState($data, iterable $state) : iterable;

    public function buildOptions($data, iterable $state, iterable $options = []) : iterable;

    public function buildForm(FormBuilderInterface $builder, $data, iterable $state, iterable $options = []) : void;

    public function renderForm($data, iterable $state, FormView $form = null) : string;
}
