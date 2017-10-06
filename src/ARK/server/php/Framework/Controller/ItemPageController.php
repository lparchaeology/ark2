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

use ARK\Error\ErrorException;
use ARK\Framework\PageController;
use ARK\Http\Error\NotFoundError;
use ARK\ORM\ORM;
use Entity\Context;
use Symfony\Component\HttpFoundation\Request;

class ItemPageController extends PageController
{
    public function buildData(Request $request)
    {
        $id = $request->attributes->get('id');
        $item = ORM::find(Context::class, $id);
        if (!$context) {
            throw new ErrorException(
                new NotFoundError('ITEM_NOT_FOUND', 'Item not found', "Item  $id not found")
            );
        }
        $data['context'] = $context;
        return $data;
    }

    public function processForm(Request $request, Form $form) : void
    {
        $clicked = $form->getClickedButton()->getName();
        $data = $form->getData();
        $item = $this->item($data);
        $parameters['id'] = $item->id();
        $request->attributes->set('parameters', $parameters);
        $actor = Service::workflow()->actor();
        if ($clicked === 'save') {
            Service::workflow()->apply($actor, 'edit', $item);
            $message = 'dime.find.update.saved';
        }
        if (!isset($message)) {
            return;
        }
        ORM::flush($item);
        Service::view()->addSuccessFlash($message);
    }

    protected function item($data) : ?Item
    {
        return $data['context'];
    }
}
