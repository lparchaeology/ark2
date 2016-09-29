<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/View/Layout.php
*
* ARK View Layout
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
* @see        http://ark.lparchaeology.com/code/src/php/View/Layout.php
* @since      2.0
*
*/

namespace ARK\View;

use Twig_Environment;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Type\FormType;
use ARK\Database\Database;
use ARK\Model\Item;

class Layout extends Group
{
    protected $template = '';

    protected function __construct(Database $db, string $layout)
    {
        parent::__construct($db, $layout);
        $this->template = 'layouts/layout.html.twig';
    }

    protected function init(array $config, Item $item = null)
    {
        parent::init($config, $item);
        if (!empty($config['template'])) {
            $this->template = $config['template'];
        }
        $this->valid = true;
    }

    public function template()
    {
        return $this->template;
    }

    public function render(
        Twig_Environment $twig,
        array $options = array(),
        FormFactoryInterface $factory = null
    ) {
        if ($this->template) {
            $options['layout'] = $this;
            if ($factory && $this->item) {
                $options['forms'] = $this->renderForms($factory);
            }
            return $twig->render($this->template, $options);
        }
        return '';
    }

    public function renderForms(FormFactoryInterface $factory)
    {
        $forms = array();
        foreach ($this->elements() as $element) {
            $forms[$element->id()] = $element->renderForms($factory);
        }
        return $forms;
    }
}
