<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/View/Subform.php
*
* ARK View Subform
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
* @see        http://ark.lparchaeology.com/code/src/php/View/Subform.php
* @since      2.0
*
*/

namespace ARK\View;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormBuilder;
use ARK\Database\Database;
use ARK\Model\Item;
use ARK\Model\Module;
use ARK\Form\Type\PanelType;

class Subform extends Group
{
    private $viewState = '';
    private $editState = '';
    private $navType = '';
    private $label = null;
    private $input = null;
    private $formType = '';

    public function __construct(Database $db = null, string $subform = null, Module $module = null, string $modtype = null)
    {
        if ($db == null || $subform == null) {
            return;
        }
        parent::__construct($db, $subform, $module, $modtype);
        $config = $db->getSubform($subform);
        $this->viewState = $config['view_state'];
        $this->editState = $config['edit_state'];
        $this->navType = $config['nav_type'];
        $this->keyword = $config['keyword'];
        $this->label = $config['label'];
        $this->input = $config['input'];
        $this->formType = $config['form_type'];
        $this->valid = true;
    }

    public function renderForms(FormFactoryInterface $factory, Item $item)
    {
        $data = $this->formData($item);
        $options['label'] = false;
        $options['elements'] = $this->elements;
        $options['keyword'] = $this->keyword;
        $formBuilder = $factory->createNamedBuilder($this->id, PanelType::class, $data, $options);
        foreach ($this->elements as $element) {
            $element->buildForm($formBuilder);
        }
        return $formBuilder->getForm()->createView();

        if ($this->formType) {
            foreach ($this->options() as $option) {
                $options['sf_options'][$option->key()] = $option->value();
            }
            $formBuilder->add($this->id, $this->formType, $options);
        }
    }
}
