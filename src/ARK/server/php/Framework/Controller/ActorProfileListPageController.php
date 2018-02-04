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

namespace ARK\Framework\Controller;

use ARK\Security\Actor;
use ARK\Framework\PageController;
use ARK\ORM\ORM;
use Symfony\Component\HttpFoundation\Request;

class ActorProfileListPageController extends PageController
{
    public function buildData(Request $request)
    {
        $actors = ORM::findAll(Actor::class);
        $data['actors']['items'] = $actors;
        return $data;
    }

    public function buildState(Request $request, $data) : iterable
    {
        $state = parent::buildState($request, $data);
        $state['image'] = 'avatar';
        return $state;
    }
}
