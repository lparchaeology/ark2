<?php

/**
 * DIME Controller
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
 * @php        >=5.6, >=7.0
 */

namespace DIME\Controller\View;

use ARK\Actor\Actor;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Page;
use DIME\DIME;
use DIME\Controller\View\DimeFormController;
use Symfony\Component\HttpFoundation\Request;

class ProfilePageController extends DimeFormController
{
    private $id = null;

    public function __invoke(Request $request, $id = null)
    {
        return $this->handleRequest($request, 'dime_page_profile', ['actor' => $id]);
    }

    public function buildData(Request $request, $slugs = [])
    {
        if ($slugs['actor'] === null) {
            $actor = Service::workflow()->actor();
            $user = Service::security()->user();
        } else {
            if (!$actor = ORM::find(Actor::class, $slugs['actor'])) {
                throw new ErrorException(new NotFoundError('ACTOR_NOT_FOUND', 'Actor not found', "Actor ".$slugs['actor']." not found"));
            }
            $data['actor'] = $actor;
            $data['user'] = Service::security()->user();
        }
        $data['actor'] = $actor;
        $data['user'] = $user;
        return $data;
    }

    public function processForm(Request $request, $form, $redirect)
    {
        $submitted = $form->getConfig()->getName();
        if ($submitted == 'password_change') {
            $data = $form->getData();
            $user = Service::security()->user();
            if (Service::security()->checkPassword($user, $data['_password'])) {
                $user->setPassword($data['password']);
                ORM::persist($user);
                ORM::flush($user);
                Service::view()->addSuccessFlash('core.user.password.change.success');
            } else {
                Service::view()->addErrorFlash('core.user.password.incorrect');
            }
        }
        if ($submitted == 'actor') {
            $actor = $form->getData();
            ORM::persist($actor);
            ORM::flush($actor);
            Service::view()->addSuccessFlash('dime.user.update.success');
        }
        return Service::redirectPath($redirect);
    }
}
