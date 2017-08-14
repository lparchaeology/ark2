<?php

/**
 * ARK Form Type.
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

namespace ARK\Form\Type;

use ARK\Model\Property;
use Symfony\Component\Form\FormBuilderInterface;

class SimplePropertyType extends AbstractPropertyType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder->setDataMapper($this);
    }

    public function mapDataToForms($data, $forms) : void
    {
    }

    public function mapFormsToData($forms, &$data) : void
    {
        // TODO Find correct way for Items/objects
        $forms = iterator_to_array($forms);
        if (is_object($data)) {
            return;
        }
        foreach ($forms as $key => $form) {
            $data[$key] = $form->getData();
            if ($data[$key] instanceof Property) {
                $data = $data[$key]->item();
                return;
            }
        }
    }

    protected function options() : iterable
    {
        return [
            'forms' => null,
            'page' => null,
            'state' => null,
        ];
    }
}
