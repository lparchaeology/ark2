<?php

/**
 * ARK Form Type.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
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
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Form\Type;

use ARK\Model\Item;
use ARK\Model\Schema\Module;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemWidgetType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        unset($options['state'], $options['widget']);
        $options['label'] = false;
        $options['mapped'] = false;
        $options['compound'] = false;
        $builder->add('item', ChoiceType::class, $options);

        $hiddenOptions['label'] = false;
        $hiddenOptions['mapped'] = false;
        $hiddenOptions['compound'] = false;
        $builder->add('module', HiddenType::class, $hiddenOptions);

        $builder->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setDefaults([
            'widget' => null,
            'choices' => null,
            'choice_value' => 'id',
            'choice_name' => 'id',
            'choice_label' => 'id',
            'state' => null,
            'placeholder' => 'core.placeholder',
            'expanded' => false,
            'multiple' => false,
        ]);
    }

    public function mapDataToForms($data, $forms) : void
    {
        $forms->rewind();
        $options = $forms->current()->getConfig()->getOptions();
        $forms = iterator_to_array($forms);

        if ($data instanceof Item) {
            $forms['module']->setData($data->schema()->module()->id());
            $forms['item']->setData($data->id());
        } elseif ($options['choices'][0]) {
            $forms['module']->setData($options['choices'][0]->schema()->module()->id());
        }
    }

    public function mapFormsToData($forms, &$data) : void
    {
        $forms = iterator_to_array($forms);
        $data = $forms['item']->getData();
    }
}
