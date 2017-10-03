<?php

/**
 * DIME Controller.
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

namespace DIME\Controller\View;

use ARK\Error\ErrorException;
use ARK\Http\Error\NotFoundError;
use ARK\Model\Item;
use ARK\ORM\ORM;
use ARK\Service;
use DIME\DIME;
use DIME\Entity\Find;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FindViewController extends DimeFormController
{
    public function __invoke(Request $request, $id = null) : Response
    {
        $request->attributes->set('find', $id);
        return parent::__invoke($request);
    }

    public function buildData(Request $request)
    {
        $id = $request->attributes->get('find');
        if (!$find = ORM::find(Find::class, $id)) {
            throw new ErrorException(new NotFoundError('ITEM_NOT_FOUND', 'Find not found', "Find $id not found"));
        }
        $data['find'] = $find;
        return $data;
    }

    public function buildState(Request $request, $data) : iterable
    {
        $state = parent::buildState($request, $data);
        // Finder cannot be changed
        $state['select']['finder']['choices'] = [$this->item($data)->value('finder')];
        return $state;
    }

    public function processForm(Request $request, Form $form) : void
    {
        $clicked = $form->getClickedButton()->getName();
        $data = $form->getData();
        $find = $this->item($data);
        $parameters['id'] = $find->id();
        $request->attributes->set('parameters', $parameters);
        if ($clicked === 'clone') {
            $request->attributes->set('redirect', 'dime.finds.add');
            return;
        }
        $actor = Service::workflow()->actor();
        if ($clicked === 'save') {
            Service::workflow()->apply($actor, 'edit', $find);
            $message = 'dime.find.update.saved';
        }
        if ($clicked === 'submit') {
            Service::workflow()->apply($actor, 'submit', $find, $find->property('museum')->value());
            $message = 'dime.find.update.submitted';
        }
        if ($clicked === 'report') {
            $result = Service::workflow()->apply($actor, 'report', $find);
            $message = 'dime.find.update.reported';
        }
        if ($clicked === 'apply') {
            $action = $form['find']['actions']->getNormData();
            //$subject = $form['find']['actors']->getNormData();
            //$date = $form['find']['date']->getNormData();
            //$text = $form['find']['textarea']->getNormData();
            $action->apply($actor, $find);
            $message = $action->keyword();
        }
        if (!isset($message)) {
            return;
        }
        ORM::flush($find);
        Service::view()->addSuccessFlash($message);
    }

    protected function item($data) : ?Item
    {
        return $data['find'];
    }
}
