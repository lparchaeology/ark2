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

namespace DIME\Framework\Controller\View;

use ARK\Http\Exception\ItemNotFoundHttpException;
use ARK\Model\Item;
use ARK\ORM\ORM;
use ARK\Service;
use DIME\DIME;
use DIME\Entity\Find;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class FindViewController extends DimePageController
{
    public function buildData(Request $request)
    {
        $id = $request->attributes->get('id');
        $find = ORM::find(Find::class, $id);
        if (!$find) {
            throw new ItemNotFoundHttpException('Find', $id);
        }
        $data['find'] = $find;
        $data['workflow'] = $find;
        return $data;
    }

    public function buildState(Request $request, $data) : iterable
    {
        $state = parent::buildState($request, $data);
        // Finder cannot be changed
        $state['select']['finder']['choices'] = [$data['find']->value('finder')];
        return $state;
    }

    public function processForm(Request $request, Form $form) : void
    {
        $id = $request->attributes->get('id');
        $parameters['id'] = $id;
        $request->attributes->set('parameters', $parameters);

        $actor = Service::workflow()->actor();
        $clicked = $form->getClickedButton()->getName();
        $update = false;
        $message = null;

        if ($form->getName() === 'find') {
            $find = $form->getData();
        } elseif ($form->getName() === 'workflow') {
            $find = ORM::find(Find::class, $id);
        }

        if ($clicked === 'clone') {
            $request->attributes->set('redirect', 'dime.finds.add');
        }

        if ($clicked === 'save') {
            Service::workflow()->apply($actor, 'edit', $find);
            $message = 'dime.find.update.saved';
            $update = true;
        }

        if ($clicked === 'submit') {
            Service::workflow()->apply($actor, 'submit', $find, $find->property('museum')->value());
            $message = 'dime.find.update.submitted';
            $update = true;
        }

        if ($clicked === 'report') {
            $result = Service::workflow()->apply($actor, 'report', $find);
            $message = 'dime.find.update.reported';
            $update = true;
        }

        if ($clicked === 'apply') {
            $action = $form['actions']->getNormData();
            //$subject = $form['find']['actors']->getNormData();
            //$date = $form['find']['date']->getNormData();
            //$text = $form['find']['textarea']->getNormData();
            $action->apply($actor, $find);
            $message = $action->keyword();
            $update = true;
        }

        if ($update) {
            ORM::flush($find);
        }
        if ($message) {
            Service::view()->addSuccessFlash($message);
        }
    }

    protected function item($data) : ?Item
    {
        return $data['find'] ?? $data['workflow'] ?? $data;
    }
}
