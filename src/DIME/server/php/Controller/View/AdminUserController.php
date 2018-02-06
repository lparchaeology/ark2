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

use ARK\Model\Item;
use ARK\ORM\ORM;
use ARK\Security\User;
use ARK\Service;
use ARK\Translation\Translation;
use ARK\Vocabulary\Vocabulary;
use DIME\Entity\Museum;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class AdminUserController extends DimePageController
{
    public function buildState(Request $request, $data) : iterable
    {
        $state = parent::buildState($request, $data);
        $state['image'] = 'avatar';
        $select['choices'] = ORM::findAll(Museum::class);
        $select['choice_value'] = 'id';
        $select['choice_name'] = 'id';
        $select['choice_label'] = 'fullname';
        $select['multiple'] = false;
        $select['placeholder'] = Translation::translate('core.placeholder');
        $state['select']['museum'] = $select;
        $state['controls']['actor'] = true;
        return $state;
    }

    public function buildData(Request $request)
    {
        $query = $request->query->all();
        $status = $query['status'] ?? null;
        if ($status) {
            $data['filter']['status'] = Vocabulary::findTerm('core.security.user.status', $status);
            $users = User::findByStatus($status);
        } else {
            $users = User::findAll();
        }

        $actors = [];
        foreach ($users as $user) {
            $actors = array_merge($actors, $user->actors()->toArray());
        }
        $data['actors']['items'] = new ArrayCollection($actors);

        $data['actor'] = null;
        $data['user'] = null;
        $data['roles'] = null;
        $actor = Service::workflow()->actor();
        $data['action'] = Service::workflow()->actions($actor, $actor);
        return $data;
    }

    public function processForm(Request $request, Form $form) : void
    {
        $submitted = $form->getConfig()->getName();
        if ($submitted === 'filter') {
            $status = $form['status']->getData();
            $query = [];
            if ($status) {
                $query['status'] = $status->name();
            }
            $request->attributes->set('parameters', $query);
            return;
        }
        if ($submitted === 'actions') {
            $action = $form['actions']->getData();
            $agent = Service::workflow()->actor();
            Service::workflow()->apply($agent, $action, $actor);
            ORM::persist($actor);
            ORM::flush($actor);
            return;
        }
    }

    protected function item($data) : ?Item
    {
        return Service::workflow()->actor();
    }
}
