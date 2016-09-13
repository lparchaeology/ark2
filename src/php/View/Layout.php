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
use ARK\Model\Module;

class Layout extends Group
{
    protected $template = '';

    public function __construct(Database $db = null, string $layout = null, Module $module = null, string $modtype = null)
    {
        if ($db == null || $layout == null) {
            return;
        }
        parent::__construct($db, $layout, $module, $modtype);
        $this->template = 'layout.html.twig';
    }

    private function loadConfig(array $config)
    {
        if (isset($config['template']) && $config['template']) {
            $this->template = $config['template'];
        }
        $this->valid = true;
    }

    public function template()
    {
        return $this->template;
    }

    public function render(Twig_Environment $twig, array $options = array(), FormFactoryInterface $factory = null, Item $item = null)
    {
        if ($this->template) {
            $options['layout'] = $this;
            if ($factory && $item) {
                $options['forms'] = $this->renderForms($factory, $item);
            }
            return $twig->render($this->template, $options);
        }
        return '';
    }

    public function renderForms(FormFactoryInterface $factory, Item $item)
    {
        $forms = array();
        foreach ($this->elements() as $element) {
            $forms[$element->id()] = $element->renderForms($factory, $item);
        }
        return $forms;
    }

    public static function fetchLayout(Database $db, string $layout, Module $module, string $modtype = null)
    {
        $config =  $db->getLayout($layout);
        if (isset($config['class'])) {
            $layout = new $config['class']($db, $layout, $module, $modtype);
            $layout->loadConfig($config);
            return $layout;
        }
        return new Layout();
    }
}
