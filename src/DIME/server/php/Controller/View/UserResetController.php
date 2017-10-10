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

use ARK\ORM\ORM;
use ARK\Security\User;
use ARK\Service;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserResetController extends DimeFormController
{
    public function __invoke(Request $request, $token = null) : Response
    {
        $query = $request->query->all();
        $token = $query['token'] ?? null;
        $user = $token ? Service::security()->userProvider()->findByResetToken($token) : null;

        if ($request->getMethod() === 'POST') {
            if ($user) {
                $password = $request->request->get('password_first');
                $repeat = $request->request->get('password_second');
                if ($password === $repeat) {
                    Service::security()->resetPassword($user, $password);
                    if (!$user->passwordRequestToken()) {
                        Service::view()->addSuccessFlash('dime.user.reset.success');
                        return Service::redirectPath('dime.home');
                    }
                    Service::view()->addErrorFlash('dime.user.reset.expired');
                } else {
                    Service::view()->addErrorFlash('dime.user.reset.matching');
                }
            } else {
                $username = $request->request->get('_username');
                $user = ORM::find(User::class, $username);
                if ($user) {
                    Service::security()->requestPassword($user);
                    Service::view()->addSuccessFlash('dime.user.reset.sent');
                    return Service::redirectPath('dime.front');
                }
                Service::view()->addErrorFlash('dime.user.reset.unknown');
            }
        }

        $context['user'] = $user;
        return Service::view()->renderResponse('user/layouts/reset.html.twig', $context);
    }

    public function processForm(Request $request, Form $form) : void
    {
        $data = $form->getData();
        $user = ORM::find(User::class, $data['_username']);
        if ($user) {
            Service::security()->resetUser($user);
        }
        Service::view()->addSuccessFlash('dime.user.reset.sent');
    }
}
