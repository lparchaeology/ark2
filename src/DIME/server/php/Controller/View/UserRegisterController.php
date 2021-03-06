<?php

/**
 * DIME Controller.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
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
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace DIME\Controller\View;

use ARK\ORM\ORM;
use ARK\Security\Actor;
use ARK\Security\Person;
use ARK\Security\Role;
use ARK\Security\User;
use ARK\Service;
use DIME\DIME;
use DIME\Entity\Museum;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class UserRegisterController extends DimePageController
{
    public function buildState(Request $request, $data) : iterable
    {
        $state = parent::buildState($request, $data);
        $state['workflow']['mode'] = 'edit';
        $select['choices'] = ORM::findAll(Museum::class);
        $select['choice_value'] = 'id';
        $select['choice_name'] = 'id';
        $select['choice_label'] = 'fullname';
        $select['multiple'] = false;
        $select['placeholder'] = 'core.placeholder';
        $state['options']['museum'] = $select;
        return $state;
    }

    public function buildData(Request $request)
    {
        $data['actor'] = new Person();
        $data['credentials'] = new User();
        $data['faq'] = 'dime.register.faq';
        return $data;
    }

    public function processForm(Request $request, Form $form) : void
    {
        $data = $form->getData();

        $user = $data['credentials'];
        $user->setId($user->username());
        $user->setLevel('ROLE_USER');
        ORM::persist($user);

        $actor = $data['actor'];
        $actor->setId($user->username());
        $actor->setValue('email', $user->email());
        ORM::persist($actor);

        $user->setName($actor->fullname());

        if (isset($data['role'])) {
            $role = ORM::find(Role::class, $data['role']['role']->name());
            $museum = $data['role']['museum'];
            $expiry = $data['role']['expiry'];
        } else {
            $role = ORM::find(Role::class, 'detectorist');
            $museum = null;
            $expiry = null;
        }

        if ($role->id() === 'detectorist') {
            $detectorist = DIME::generateDetectoristId();
            $actor->setValue('detectorist_id', $detectorist);
        }

        Service::security()->createActorRole($actor, $role, $museum, $expiry);
        Service::security()->registerUser($user, $actor);

        if (Service::security()->isLoggedIn()) {
            Service::view()->addSuccessFlash('dime.admin.user.register');
        } else {
            Service::view()->addSuccessFlash('dime.user.register');
        }
    }
}
