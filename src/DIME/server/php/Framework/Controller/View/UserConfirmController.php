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

use ARK\Security\User;
use ARK\Service;
use DIME\DIME;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserConfirmController extends DimeFormController
{
    public function __invoke(Request $request, $token = null) : Response
    {
        $query = $request->query->all();
        $token = $query['token'] ?? null;
        if (!$token) {
            Service::view()->addErrorFlash('dime.user.verify.missing');
            return Service::redirectPath('dime.user.login');
        }
        $user = Service::security()->userProvider()->findByVerificationToken($token);
        if (!$user) {
            Service::view()->addErrorFlash('dime.user.verify.unknown');
            return Service::redirectPath('dime.user.login');
        }
        Service::security()->verifyUser($user);
        if ($user->isEnabled()) {
            Service::view()->addSuccessFlash('dime.user.verify.enabled');
        } elseif ($user->isVerified()) {
            Service::view()->addSuccessFlash('dime.user.verify.verified');
        } else {
            Service::view()->addErrorFlash('dime.user.verify.expired');
        }
        return Service::redirectPath('dime.user.login');
    }
}
