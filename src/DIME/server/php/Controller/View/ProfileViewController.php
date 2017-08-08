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
use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Page;
use DIME\DIME;
use DIME\Entity\Find;
use Symfony\Component\HttpFoundation\Request;

class ProfileViewController extends DimeFormController
{
    public function __invoke(Request $request, $id)
    {
        $request->attributes->set('page', 'dime_page_profile');
        $request->attributes->set('actor', $id);
        return $this->handleRequest($request);
    }

    public function buildState(Request $request) : iterable
    {
        $state = parent::buildState($request);
        $state['image'] = 'avatar';
        return $state;
    }

    public function buildData(Request $request)
    {
        $id = $request->attributes->get('actor');
        if (!$actor = ORM::find(Actor::class, $id)) {
            throw new ErrorException(new NotFoundError('PROFILE_NOT_FOUND', 'Profile not found', "Profile for user $id not found"));
        }
        $data['actor'] = $actor;
        $items = Service::database()->getActorFinds($actor->id());
        $data['finds'] = ORM::findBy(Find::class, ['item' => $items]);
        return $data;
    }

    public function buildWorkflow(Request $request, $data, iterable $state) : iterable
    {
        $workflow['mode'] = 'edit';
        $workflow['actor'] = $state['actor'];
        return $workflow;
    }
}
