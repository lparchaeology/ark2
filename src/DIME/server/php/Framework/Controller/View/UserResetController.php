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

use ARK\ORM\ORM;
use ARK\Security\User;
use ARK\Service;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserResetController extends DimeFormController
{
    public function __invoke(Request $request, $token = null) : Response
    {
        $page = $this->buildPage($request);
        $parent = $this->buildView($request);
        $view = $page->buildView($parent);

        if ($view['state']['mode'] === 'deny') {
            throw new AccessDeniedException('core.error.access.denied');
        }

        if ($request->getMethod() === 'POST') {
            if ($view['data']['user']) {
                $password = $request->request->get('password_first');
                $repeat = $request->request->get('password_second');
                if ($password === $repeat) {
                    $user = $view['data']['user'];
                    Service::security()->resetPassword($user, $password);
                    if ($user->passwordRequestToken() === '') {
                        Service::security()->loginAsUser($user, 'secured', $request);
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

        $context = $this->buildContext($request, $view);
        return Service::view()->renderResponse('user/layouts/reset.html.twig', $context);
    }

    protected function buildData(Request $request)
    {
        $query = $request->query->all();
        $data['token'] = $query['token'] ?? null;
        $data['user'] = $data['token'] ? Service::security()->userProvider()->findByResetToken($data['token']) : null;
        return $data;
    }
}
