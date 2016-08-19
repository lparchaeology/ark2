<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Form/Type/PanelType.php
*
* ARK Panel Form Type
*
* PHP version 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Heritage LLP.
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @package    ark
* @author     John Layt <j.layt@lparchaeology.com>
* @copyright  2016 L - P : Heritage LLP.
* @license    GPL-3.0+
* @see        http://ark.lparchaeology.com/code/src/php/Form/Type/PanelType.php
* @since      2.0
*
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
    function buildForm(FormBuilderInterface $formBuilder, array $options)
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
