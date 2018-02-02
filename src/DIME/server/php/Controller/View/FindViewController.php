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

use ARK\ARK;
use ARK\Http\Exception\ItemNotFoundHttpException;
use ARK\Model\Fragment\StringFragment;
use ARK\Model\Item;
use ARK\Model\LocalText;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Workflow\Action;
use DateInterval;
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
        $data['status'] = $find;
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
        $alert = null;

        if ($form->getName() === 'find') {
            $find = $form->getData();
        } elseif ($form->getName() === 'workflow') {
            $find = ORM::find(Find::class, $id);
            $message = null;
            if (isset($form['message'])) {
                $message = $form['message']->getData();
                $message = $message ? new LocalText($message, Service::locale()) : null;
            }
        }

        if ($clicked === 'clone') {
            $request->attributes->set('redirect', 'dime.finds.add');
        }

        if ($clicked === 'save') {
            Service::workflow()->apply($actor, 'edit', $find);
            $alert = 'dime.find.update.saved';
            $update = true;
        }

        if (in_array($clicked, ['report', 'submit', 'send'], true)) {
            $action = Action::find($find->schema()->id(), $clicked);
            $action->apply($actor, $find, $find->value('museum'), $message);
            $alert = $action->keyword().'.success';
            $update = true;
        }

        if ($clicked === 'withhold') {
            $action = Action::find($find->schema()->id(), $clicked);
            Service::workflow()->apply($actor, 'withhold', $find);
            $publish = ARK::timestamp();
            $publish->add(new DateInterval('P1Y'));
            $find->setValue('publish', $publish);
            $alert = $action->keyword().'.success';
            $update = true;
        }

        if (in_array($clicked, ['publish', 'discard', 'destroy', 'lose', 'recover'], true)) {
            $action = Action::find($find->schema()->id(), $clicked);
            $action->apply($actor, $find, null, $message);
            $alert = $action->keyword().'.success';
            $update = true;
        }

        if ($clicked === 'apply') {
            $action = $form['actions']->getNormData();
            if ($action) {
                $action->apply($actor, $find, null, $message);
                $alert = $action->keyword().'.success';
                $update = true;
            }
            if ($action->name() === 'claim') {
                $file = DIME::generateTreasureClaimFile([$find], $find->value('museum'), $find->value('finder'), $actor);
                $find->setValue('claim', $file);
            }
        }

        if ($update) {
            ORM::flush($find);
            // HACK Workaround bug in ObjectFragment not rehydrating...
            if (isset($file)) {
                $frag = ORM::findOneBy(StringFragment::class, ['module' => 'file', 'item' => $file->id(), 'attribute' => 'name']);
                $frag->setValue('Danefae'.$file->id().'.pdf');
                ORM::flush($frag);
            }
        }
        if ($alert) {
            Service::view()->addSuccessFlash($alert);
        }
    }

    protected function item($data) : ?Item
    {
        return $data['find'] ?? $data['workflow'] ?? $data;
    }
}
