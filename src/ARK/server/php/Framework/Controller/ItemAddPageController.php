<?php

/**
 * Page Controller.
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

namespace ARK\Framework\Controller;

use ARK\Framework\PageController;
use ARK\Model\Item;
use ARK\ORM\ORM;
use Entity\Context;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class ItemAddPageController extends PageController
{
    public function buildData(Request $request)
    {
        $item = new Context();
        $data['context'] = $item;
        return $data;
    }

    public function processForm(Request $request, Form $form) : void
    {
        $clicked = $form->getClickedButton()->getName();
        $data = $form->getData();
        $item = $this->item($data);
        ORM::persist($item);
        $actor = Service::workflow()->actor();
        Service::workflow()->apply($actor, 'add', $item);
        ORM::flush($item);
        $parameters['id'] = $item->id();
        $request->attributes->set('parameters', $parameters);
        Service::view()->addSuccessFlash('core.item.added', $parameters);
    }

    protected function item($data) : ?Item
    {
        if (is_array($data)) {
            $data['context'] ?? null;
        }
        if ($data instanceof Item) {
            return $data;
        }
        return null;
    }
}
