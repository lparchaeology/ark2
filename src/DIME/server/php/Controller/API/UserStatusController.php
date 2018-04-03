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

namespace DIME\Controller\API;

use ARK\Framework\FormController;
use ARK\ORM\ORM;
use ARK\Security\Actor;
use ARK\Security\User;
use ARK\Service;
use DIME\DIME;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class UserStatusController extends FormController
{
    public function buildData(Request $request)
    {
        $actor = Actor::find($request->attributes->get('id'));
        $data['user_status']['actor'] = $actor;
        $admin = Service::workflow()->actor();
        $data['user_status']['actions'] = Service::workflow()->actionable($admin, $actor);
        return $data;
    }

    public function buildState(Request $request, $data) : iterable
    {
        $state = parent::buildState($request, $data);
        $query = $request->query->all();

        $actor = $data['user_status']['actor'];
        $actions = $data['user_status']['actions'];
        if ($actions->count() > 0) {
            $state['workflow']['mode'] = 'edit';
            $state['actions'] = $actions;
            $select['choices'] = $state['actions'];
            $select['choice_value'] = 'name';
            $select['choice_name'] = 'name';
            $select['choice_label'] = 'keyword';
            $select['multiple'] = false;
            $select['placeholder'] = 'core.placeholder.default';
            $state['select']['actions'] = $select;
        }

        return $state;
    }

    public function processForm(Request $request, Form $form) : void
    {
        $id = $request->attributes->get('id');
        $submitted = $form->getConfig()->getName();
        if ($submitted === 'user_status') {
            $action = $form['actions']->getData();
            $admin = Service::workflow()->actor();
            $actor = Actor::find($id);
            Service::workflow()->apply($admin, $action->name(), $actor);
            ORM::persist($actor);

            $user = User::find($id);
            switch ($action->name()) {
                case 'disable':
                    $user->disable();
                    break;
                case 'enable':
                    $user->enable();
                    break;
                case 'lock':
                    $user->lock();
                    break;
                case 'verify':
                    $user->verify();
                    break;
            }
            ORM::persist($user);

            ORM::flush();
            $request->attributes->set('_status', 'success');
            $request->attributes->set('_message', 'dime.admin.user.status.changed');
        }
    }
}
