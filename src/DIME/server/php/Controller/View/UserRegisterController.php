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

use ARK\Actor\Actor;
use ARK\Actor\Person;
use ARK\ORM\ORM;
use ARK\Security\User;
use ARK\Service;
use ARK\View\Page;
use ARK\Workflow\Role;
use DIME\DIME;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class UserRegisterController extends DimeFormController
{
    public function __invoke(Request $request)
    {
        $request->attributes->set('page', 'core_page_user_register');
        $request->attributes->set('redirect', 'front');
        return $this->handleRequest($request);
    }

    public function buildData(Request $request)
    {
        $data['actor'] = new Person();
        return $data;
    }

    public function buildWorkflow(Request $request, $data, iterable $state) : iterable
    {
        $workflow['mode'] = 'edit';
        $workflow['actor'] = $state['actor'];
        return $workflow;
    }

    public function processForm(Request $request, Form $form) : void
    {
        $data = $form->getData();
        $credentials = $data['credentials'];
        $role = $data['role']['role'];
        $comments = $data['role']['comments'];

        $actor = $data['actor'];
        $actor->setItem($credentials['_username']);

        $user = Service::security()->createUser(
            $credentials['_username'],
            $credentials['email'],
            $credentials['password'],
            $actor->fullname()
        );

        $role = ORM::find(Role::class, $role->name());

        $museum = $actor->property('museum')->value();
        Service::security()->registerUser($user, $actor, $role, $museum);

        Service::workflow()->apply($actor, 'register', $actor);
        ORM::flush($actor);

        $request->attributes->set('flash', 'success');
        $request->attributes->set('message', 'dime.user.register.success');
    }
}
