<?php

/**
 * Page Controller.
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

namespace ARK\Security\Controller;

use ARK\Framework\PageController;
use ARK\Security\User;
use ARK\Service;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class UserResetPageController extends PageController
{
    protected function buildData(Request $request)
    {
        $query = $request->query->all();
        $data['token'] = $query['token'] ?? null;
        $data['user'] = Service::security()->userProvider()->findByResetToken($data['token']);
        return $data;
    }

    protected function processForm(Request $request, Form $form) : void
    {
        $clicked = $form->getClickedButton()->getName();
        $data = $form->getData();

        if ($clicked === 'set_password') {
            $user = $data['user'];
            Service::security()->resetPassword($user, $password);
            if ($user->passwordRequestToken() === '') {
                Service::security()->loginAsUser($user, 'secured', $request);
                Service::view()->addSuccessFlash('core.user.reset.success');
                $request->attributes->set('redirect', 'core.home');
            } else {
                Service::view()->addErrorFlash('core.user.reset.expired');
            }
        }

        if ($clicked === 'reset') {
            $user = $data['user'];
            if ($user) {
                Service::security()->requestPassword($user);
                Service::view()->addSuccessFlash('core.user.reset.sent');
                $request->attributes->set('redirect', 'core.front');
            } else {
                Service::view()->addErrorFlash('core.user.reset.unknown');
            }
        }
    }
}
