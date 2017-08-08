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

use ARK\Actor\Person;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Vocabulary\Term;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class AdminUserController extends DimeFormController
{
    public function __invoke(Request $request)
    {
        $request->attributes->set('page', 'dime_page_admin_user');
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
        $query = $request->query->all();

        if (isset($query['status'])) {
            $status = ORM::findOneBy(Term::class, [
                'concept' => 'core.security.status',
                'term' => $query['status'],
            ]);
            $data['filter']['status'] = $status;
            $items = Service::database()->userSearch($query);
            $data['actors'] = ORM::findBy(Person::class, ['item' => $items]);
        } else {
            $data['actors'] = ORM::findAll(Person::class);
        }

        $data['actor'] = null;
        $data['user'] = null;
        $actor = Service::workflow()->actor();
        $data['action'] = Service::workflow()->actions($actor, $actor);
        return $data;
    }

    public function buildWorkflow(Request $request, $data, iterable $state) : iterable
    {
        $actor = $state['actor'];
        $workflow['mode'] = 'edit';
        $workflow['actor'] = $actor;
        $workflow['actions'] = Service::workflow()->updateActions($actor, $actor);
        $workflow['actors'] = Service::workflow()->actors($actor, $actor);
        return $workflow;
    }

    public function processForm(Request $request, Form $form) : void
    {
        $query = [];
        $submitted = $form->getConfig()->getName();
        if ($submitted === 'filter') {
            $status = $form['status']->getData();
            if ($status) {
                $query['status'] = $status->name();
            }
            $request->attributes->set('parameters', $query);
        }
        if ($submitted === 'actions') {
            $action = $form['actions']->getData();
            $agent = Service::workflow()->actor();
            //Service::workflow()->apply($agent, $action, $actor);
            //ORM::persist($actor);
            //ORM::flush($actor);
        }
    }
}
