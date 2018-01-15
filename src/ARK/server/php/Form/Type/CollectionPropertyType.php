<?php

/**
 * ARK Item Form Type.
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

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollectionPropertyType extends AbstractPropertyType
{
    public function buildForm(FormBuilderInterface $builder, iterable $options) : void
    {
        dump($options);
        return;
        $this->addForm($builder, $options['state'], 'display');
        $this->addForm($builder, $options['state'], 'static');
        $this->addForm($builder, $options['state'], 'value');
        $this->addForm($builder, $options['state'], 'format');
        $this->addForm($builder, $options['state'], 'parameter');
        //$builder->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setDefaults([
            'allow_add' => true,
            'allow_delete' => true,
            'delete_empty' => true,
            'attr' => ['class' => 'collection'],
        ]);
    }

    public function getBlockPrefix()
    {
        return 'collection';
    }
}
