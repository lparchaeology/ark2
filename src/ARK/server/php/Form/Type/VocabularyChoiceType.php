<?php

/**
 * ARK Hidden Choice Form Type
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

use ARK\ORM\ORM;
use ARK\Vocabulary\Term;
use ARK\Vocabulary\Vocabulary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VocabularyChoiceType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setDataMapper($this);
        $vocabulary = $options['vocabulary'];
        foreach ($vocabulary->terms() as $term) {
            $fieldOptions['choices'][$term->keyword()] = $term->name();
        }
        $fieldOptions['placeholder'] = $vocabulary->concept();
        $fieldOptions['mapped'] = false;
        $fieldOptions['label'] = false;
        $builder->add('concept', HiddenType::class, []);
        $builder->add('name', ChoiceType::class, $fieldOptions);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'compound' => true,
            'vocabulary' => null,
            'data_class' => Term::class,
            'empty_data' => null,
        ]);
    }

    public function mapDataToForms($term, $forms)
    {
        $forms = iterator_to_array($forms);
        if ($term instanceof Term) {
            $forms['name']->setData($term->name());
            $forms['concept']->setData($term->vocabulary()->concept());
        }
    }

    public function mapFormsToData($forms, &$term)
    {
        $forms = iterator_to_array($forms);
        $concept = $forms['concept']->getData();
        $name = $forms['name']->getData();
        if ($name) {
            $term = ORM::find(Term::class, ['concept' => $concept, 'term' => $name]);
        }
    }

    public function getName()
    {
        return 'vocabularychoice';
    }
}
