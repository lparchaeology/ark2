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
use ARK\Actor\Museum;
use ARK\Actor\Person;
use ARK\ORM\ORM;
use ARK\Security\User;
use ARK\Service;
use ARK\Workflow\Role;
use DIME\DIME;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class UserRegisterController extends DimeFormController
{
    public function buildState(Request $request) : iterable
    {
        $state = parent::buildState($request);
        $state['options']['museum']['choices'] = ORM::findAll(Museum::class);
        $state['options']['museum']['multiple'] = false;
        $state['options']['museum']['placeholder'] = Service::translate('dime.placeholder');
        return $state;
    }

    public function buildData(Request $request)
    {
        $data['actor'] = new Person();
        $data['faq'] = 'dime.register.faq';
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

        $actor = $data['actor'];
        $actor->setItem($credentials['_username']);
        $actor->property('email')->setValue($credentials['email']);
        ORM::persist($actor);

        $user = Service::security()->createUser(
            $credentials['_username'],
            $credentials['email'],
            $credentials['password'],
            $actor->fullname()
        );

        $actorUser = Service::security()->createActorUser($actor, $user);

        if (isset($data['role'])) {
            $role = ORM::find(Role::class, $data['role']['role']->name());
            $museum = $data['role']['museum'];
            $expiry = $data['role']['expiry'];
        } else {
            $role = ORM::find(Role::class, 'detectorist');
            $museum = null;
            $expiry = null;
        }

        $actorRole = Service::security()->createActorRole($actor, $role, $museum, $expiry);

        if ($role->id() === 'detectorist') {
            $detectorist = DIME::generateDetectoristId();
            $actor->property('detectorist_id')->setValue($detectorist);
        }

        $registeredBy = (Service::security()->isLoggedIn() ? Service::workflow()->actor() : $actor);
        Service::workflow()->apply($actor, 'register', $registeredBy);

        Service::security()->registerUser($user, $actor);

        if ($user->isEnabled()) {
            Service::security()->loginAsUser($user, 'default', $request);
        }
        $request->attributes->set('flash', 'success');
        $request->attributes->set('message', 'dime.user.register.success');
    }
}
