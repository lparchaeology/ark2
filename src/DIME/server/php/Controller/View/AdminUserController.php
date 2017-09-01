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

use ARK\Actor\Museum;
use ARK\Actor\Person;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Vocabulary\Term;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class AdminUserController extends DimeFormController
{
    public function buildState(Request $request, $data) : iterable
    {
        $state = parent::buildState($request, $data);
        $state['image'] = 'avatar';
        $state['options']['museum']['choices'] = ORM::findAll(Museum::class);
        $state['options']['museum']['choice_value'] = 'id';
        $state['options']['museum']['choice_name'] = 'id';
        $state['options']['museum']['choice_label'] = 'fullname';
        $state['options']['museum']['multiple'] = false;
        $state['options']['museum']['placeholder'] = Service::translate('core.placeholder');
        return $state;
    }

    public function buildData(Request $request)
    {
        $query = $request->query->all();

        if (isset($query['status'])) {
            $status = ORM::findOneBy(Term::class, [
                'concept' => 'core.security.status',
                'term' => $query['status'],
            ]);
            $data['filter']['status'] = $status;
            $items = Service::database()->userSearch($query);
            $data['actors']['items'] = ORM::findBy(Person::class, ['id' => $items]);
        } else {
            $data['actors']['items'] = ORM::findAll(Person::class);
        }

        $data['actor'] = null;
        $data['user'] = null;
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
            //Service::workflow()->apply($agent, $action, $actor);
            //ORM::persist($actor);
            //ORM::flush($actor);
            return;
        }
        $actor = $form['actor']->getData();
        if ($submitted === 'password_set') {
            $user = Service::security()->userProvider()->loadUserByUsername($actor->id());
            $credentials = $form['password_set']->getData();
            $user->setPassword($credentials['_password']);
            ORM::persist($user);
            ORM::flush($user);
            Service::view()->addSuccessFlash('dime.admin.user.password.set');
        }
        if ($submitted === 'role_add') {
            $add = $form['role_add']->getData();
            $role = ORM::find(Role::class, $add['role']->name());
            $actorRole = Service::security()->createActorRole($actor, $role, $add['museum'], $add['expiry']);
            ORM::flush($actorRole);
            Service::view()->addSuccessFlash('dime.admin.user.role.add');
        }
    }

    protected function item($data) : ?Item
    {
        return Service::workflow()->actor();
    }
}
