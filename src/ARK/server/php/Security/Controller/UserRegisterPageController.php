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

namespace ARK\Security\Controller;

use ARK\Actor\Actor;
use ARK\Actor\Person;
use ARK\Framework\PageController;
use ARK\ORM\ORM;
use ARK\Security\User;
use ARK\Service;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class UserRegisterPageController extends PageController
{
    public function buildData(Request $request)
    {
        $data['actor'] = new Person();
        $data['user'] = new User();
        $data['user']->setLevel('ROLE_USER');
        return $data;
    }

    public function buildState(Request $request, $data) : iterable
    {
        $state = parent::buildState($request, $data);
        $state['workflow']['mode'] = 'edit';
        return $state;
    }

    public function processForm(Request $request, Form $form) : void
    {
        $data = $form->getData();

        $credentials = $data['credentials'];

        $actor = $data['actor'];
        $actor->setId($credentials['_username']);
        $actor->property('email')->setValue($credentials['email']);
        ORM::persist($actor);

        $user = Service::security()->createUser(
            $credentials['_username'],
            $credentials['email'],
            $credentials['password'],
            $actor->fullname()
        );

        if (!isset($data['role'])) {
            $data['role']['role'] = null;
            $data['role']['agency'] = null;
            $data['role']['expiry'] = null;
        }
        Service::security()->createActorRole(
            $actor,
            $data['role']['role'],
            $data['role']['agency'],
            $data['role']['expiry']
        );

        Service::security()->registerUser($user, $actor);

        if (Service::security()->isLoggedIn()) {
            Service::view()->addSuccessFlash('core.admin.user.register');
        } elseif ($user->isEnabled()) {
            Service::view()->addSuccessFlash('core.security.user.register.enabled');
            Service::security()->loginAsUser($user, 'default', $request);
        } else {
            Service::view()->addSuccessFlash('core.security.user.register.confirm');
        }
    }
}
