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

namespace DIME\Controller\API;

use ARK\Actor\Actor;
use ARK\Framework\ApiController;
use ARK\Model\Item;
use ARK\ORM\ORM;
use ARK\Security\User;
use ARK\Service;
use DIME\DIME;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserActorController extends ApiController
{
    public function __invoke(Request $request, string $id = null) : Response
    {
        // TODO Error id no id
        $request->attributes->set('_form', 'dime_user_actor');
        $request->attributes->set('_id', $id);
        return $this->handleRequest($request);
    }

    public function buildData(Request $request)
    {
        $actor = $request->attributes->get('_id');
        $data['actor'] = ORM::find(Actor::class, $actor);
        return $data;
    }

    public function buildState(Request $request, $data) : iterable
    {
        $state = parent::buildState($request, $data);
        $state['image'] = 'avatar';
        return $state;
    }

    public function processForm(Request $request, Form $form) : void
    {
        $id = $request->attributes->get('_id');
        $submitted = $form->getConfig()->getName();

        if ($submitted === 'password_set') {
            $data = $form->getData();
            $user = ORM::find(User::class, $id);
            $user->setPassword($data['password']);
            ORM::flush($user);
            $request->attributes->set('_status', 'success');
            $request->attributes->set('_message', 'dime.admin.user.password.set');
        }

        if ($submitted === 'role_add') {
            $data = $form->getData();
            $actor = ORM::find(Actor::class, $id);
            $ar = Service::security()->createActorRole($actor, $data['role'], $data['museum'], $data['expiry']);
            ORM::flush($ar);
            $request->attributes->set('_status', 'success');
            $request->attributes->set('_message', 'dime.admin.user.role.added');
        }

        if ($submitted === 'actor') {
            dump($form->getName());
            $actor = $form->getData();
            dump($actor->id());
            dump($actor->property('email')->value());
            ORM::flush($actor);
            dump($actor->property('email')->value());
            $actor = ORM::find(Actor::class, $id);
            dump($actor->id());
            dump($actor->property('email')->value());
            dump();
            $request->attributes->set('_status', 'success');
            $request->attributes->set('_message', 'dime.admin.user.updated');
        }
    }

    protected function item($data) : ?Item
    {
        return $data['actor'];
    }
}
