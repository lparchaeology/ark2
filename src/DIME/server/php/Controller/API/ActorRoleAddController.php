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

namespace DIME\Controller\API;

use ARK\Actor\Actor;
use ARK\Actor\Museum;
use ARK\Framework\ApiController;
use ARK\ORM\ORM;
use ARK\Security\User;
use ARK\Service;
use ARK\Workflow\Role;
use DIME\DIME;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ActorRoleAddController extends ApiController
{
    public function __invoke(Request $request, string $id = null) : Response
    {
        // TODO Error id no id
        $request->attributes->set('_form', 'core_user_role_add');
        $request->attributes->set('_id', $id);
        return $this->handleRequest($request);
    }

    public function buildState(Request $request, $data) : iterable
    {
        $state = parent::buildState($request, $data);
        $select['choices'] = ORM::findAll(Museum::class);
        $select['choice_value'] = 'id';
        $select['choice_name'] = 'id';
        $select['choice_label'] = 'fullname';
        $select['multiple'] = false;
        $select['placeholder'] = Service::translate('core.placeholder');
        $state['select']['museum'] = $select;
        return $state;
    }

    public function processForm(Request $request, Form $form) : void
    {
        $id = $request->attributes->get('_id');
        $submitted = $form->getConfig()->getName();
        if ($submitted === 'role_add') {
            $data = $form->getData();
            $actor = ORM::find(Actor::class, $id);
            $role = ORM::find(Role::class, $data['role']->name());
            $ar = Service::security()->createActorRole($actor, $role, $data['museum'], $data['expiry']);
            ORM::flush($ar);
            $request->attributes->set('_status', 'success');
            $request->attributes->set('_message', 'dime.admin.user.role.added');
        }
    }
}
