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
use ARK\Service;
use DIME\DIME;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class UserProfileController extends DimePageController
{
    public function buildState(Request $request, $data) : iterable
    {
        $state = parent::buildState($request, $data);
        $state['image'] = 'avatar';
        return $state;
    }

    public function buildData(Request $request)
    {
        $data['actor'] = Service::workflow()->actor();
        $data['user'] = Service::security()->user();
        return $data;
    }

    public function processForm(Request $request, Form $form) : void
    {
        $submitted = $form->getConfig()->getName();
        if ($submitted === 'password_change') {
            $data = $form->getData();
            $user = Service::security()->user();
            if (Service::security()->checkPassword($user, $data['_password'])) {
                $user->setPassword($data['password']);
                ORM::persist($user);
                ORM::flush($user);
                Service::view()->addSuccessFlash('core.user.password.change');
            } else {
                Service::view()->addSuccessFlash('core.user.password.change');
            }
        }
        if ($submitted === 'actor') {
            $actor = $form->getData();
            ORM::persist($actor);
            ORM::flush($actor);
            Service::view()->addSuccessFlash('dime.find.update');
        }
    }
}
