<?php

/**
 * ARK Panel Form Type
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

namespace ARK\Form\Type;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PanelType extends AbstractType
{
    // {{{ buildForm()
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        foreach ($options['elements'] as $element) {
            $element->buildForm($formBuilder);
        }
        $formBuilder->add('lock', SubmitType::class);
        $formBuilder->add('save', SubmitType::class);
    }
    // }}}
    // {{{ buildView()
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['keyword'] = $options['keyword'];
        $view->vars['title'] = $options['title'];
    }
    // {{{ configureOptions()
    // }}}
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'keyword' => '',
            'title' => '',
            'elements' => array(),
        ));
    }
    // }}}
    // {{{ getParent()
    public function getParent()
    {
        return FormType::class;
    }
    // }}}
}
