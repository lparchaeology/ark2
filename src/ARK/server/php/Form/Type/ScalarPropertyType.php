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
 */

namespace ARK\Form\Type;

use ARK\Model\Item;
use ARK\Model\LocalText;
use ARK\Model\Property;
use ARK\ORM\ORM;
use ARK\Vocabulary\Term;
use ARK\Vocabulary\Vocabulary;
use DateTime;
use Symfony\Component\Form\FormBuilderInterface;

class ScalarPropertyType extends AbstractPropertyType
{
    public function buildForm(FormBuilderInterface $builder, iterable $options) : void
    {
        $field = $options['state']['field'];
        $dataclass = $field->attribute()->dataclass();
        if (isset($options['state']['display'])) {
            $builder->add($options['state']['display']['name'], $options['state']['display']['type'], $options['state']['display']['options']);
        }
        $builder->add($dataclass->valueName(), $options['state']['value']['type'], $options['state']['value']['options']);
        if ($options['state']['parameter'] !== null) {
            $builder->add($dataclass->parameterName(), $options['state']['parameter']['type'], $options['state']['parameter']['options']);
        }
        if ($options['state']['format'] !== null) {
            $builder->add($dataclass->formatName(), $options['state']['format']['type'], $options['state']['format']['options']);
        }
        $builder->setDataMapper($this);
    }

    public function mapDataToForms($property, $forms) : void
    {
        if (!$property instanceof Property) {
            return;
        }
        $options = $this->propertyOptions($forms);
        $forms = iterator_to_array($forms);
        $attribute = $property->attribute();
        $dataclass = $attribute->dataclass();
        $display = null;
        $displayName = $options['state']['display']['name'] ?? null;
        $value = null;
        $valueName = $dataclass->valueName();
        $format = null;
        $formatName = $dataclass->formatName();
        $parameter = null;
        $parameterName = $dataclass->parameterName();

        $value = $property->value();
        // TODO WEAK COMPARISON to empty value!
        if ($value === null || $value === $attribute->emptyValue()) {
            $value = $options['default_data'];
        }

        if (isset($options['state']['display'])) {
            if ($attribute->hasMultipleOccurrences()) {
                $display = [];
                if (is_iterable($value)) {
                    foreach ($value as $val) {
                        $display[] = $this->mapDisplayValue($val, $valueName, $options['state']['display']['property']);
                    }
                }
            } else {
                $display = $this->mapDisplayValue($value, $valueName, $options['state']['display']['property']);
            }
        }

        if (!isset($options['state']['value']['options']['choices'])) {
            if ($attribute->hasMultipleOccurrences()) {
                $vals = [];
                if (is_iterable($value)) {
                    foreach ($value as $val) {
                        $vals = [];
                        if ($value instanceof Item) {
                            $parameter = $val->schema()->module()->id();
                            $vals[] = $val->id();
                        } elseif ($val instanceof Term) {
                            $parameter = $val->concept()->concept();
                            $vals[] = $val->name();
                        } else {
                            $vals[] = $val;
                        }
                    }
                }
                $value = $vals;
            } else {
                if ($value instanceof Item) {
                    $parameter = $value->schema()->module()->id();
                    $value = $value->id();
                } elseif ($value instanceof Term) {
                    $parameter = $value->concept()->concept();
                    $value = $value->name();
                } elseif ($value instanceof DateTime) {
                    // TODO LOCALISE!!!
                    $value = $value->format('Y-m-d H:i:s');
                }
            }
        }

        if (!$attribute->hasMultipleOccurrences() && is_array($value)) {
            $format = $value[$formatName] ?? $format;
            $parameter = $value[$parameterName] ?? $parameter;
            $value = $value[$valueName] ?? $value;
        }

        $forms[$valueName]->setData($value);

        if ($displayName && isset($forms[$displayName])) {
            $forms[$displayName]->setData($display);
        }

        if ($formatName && isset($forms[$formatName])) {
            if ($format === null) {
                $vocab = $property->attribute()->dataclass()->formatVocabulary();
                if ($vocab) {
                    $vocab = ORM::find(Vocabulary::class, $vocab);
                    $format = $vocab->defaultTerm()->name();
                }
            }
            $forms[$formatName]->setData($format);
        }

        if ($parameterName && isset($forms[$parameterName])) {
            if ($parameter === null) {
                $vocab = $property->attribute()->dataclass()->parameterVocabulary();
                if ($vocab) {
                    $vocab = ORM::find(Vocabulary::class, $vocab);
                    $parameter = $vocab->defaultTerm()->name();
                }
            }
            $forms[$parameterName]->setData($parameter);
        }
    }

    public function mapFormsToData($forms, &$property) : void
    {
        if (!$property instanceof Property) {
            return;
        }
        $options = $this->propertyOptions($forms);
        if ($options['state']['modus'] === 'static') {
            return;
        }
        $forms = iterator_to_array($forms);
        $dataclass = $property->attribute()->dataclass();
        $value = null;
        if ($dataclass->isAtomic() || ($dataclass->entity() && !isset($options['state']['display']))) {
            $value = $forms[$dataclass->valueName()]->getData();
            if (isset($options['state']['value']['choices'])
                && $options['placeholder']
                && ($value === $placeholder || $value === Service::translate($placeholder))
            ) {
                $value = null;
            }
        } else {
            $valueName = $dataclass->valueName();
            $value[$valueName] = $forms[$valueName]->getData();
            if ($formatName = $dataclass->formatName()) {
                $value[$formatName] = isset($forms[$formatName]) ? $forms[$formatName]->getData() : null;
            }
            if ($parameterName = $dataclass->parameterName()) {
                $value[$parameterName] = isset($forms[$parameterName]) ? $forms[$parameterName]->getData() : null;
            }
            ksort($value);
            if ($dataclass->entity()) {
                try {
                    $value = ORM::find($dataclass->entity(), $value);
                } catch (\Throwable $e) {
                    $value = null;
                }
            }
        }
        $property->setValue($value);
    }

    protected function options() : iterable
    {
        return [
            'compound' => true,
        ];
    }

    protected function mapDisplayValue($value, ?string $valueName, ?string $property = null)
    {
        $display = $value;
        if ($display instanceof Item) {
            if ($property) {
                $display = $display->property($property)->value();
            } else {
                return $display->id();
            }
        }
        if ($display instanceof Term) {
            return $display->keyword();
        }
        if ($display instanceof LocalText) {
            return $display->content();
        }
        if ($display instanceof DateTime) {
            // TODO LOCALISE!!!
            return $display->format('Y-m-d H:i:s');
        }
        if (is_array($display) && isset($display[$valueName])) {
            return $display[$valueName];
        }
        return $display;
        if ($display) {
            return $display;
        }
        return Service::translate('core.placeholder');
    }
}
