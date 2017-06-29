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

use ARK\Error\ErrorException;
use ARK\Http\Error\NotFoundError;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Page;
use DIME\DIME;
use DIME\Controller\View\DimeFormController;
use DIME\Entity\Find;
use Symfony\Component\HttpFoundation\Request;

class FindViewController extends DimeFormController
{
    public function __invoke(Request $request, $id)
    {
        $request->attributes->set('page', 'dime_page_find');
        $request->attributes->set('find', $id);
        return $this->handleRequest($request);
    }

    public function buildData(Request $request)
    {
        $id = $request->attributes->get('find');
        if (!$find = ORM::find(Find::class, $id)) {
            throw new ErrorException(new NotFoundError('ITEM_NOT_FOUND', 'Find not found', "Find $id not found"));
        }
        $data['find'] = $find;
        return $data;
    }

    public function buildWorkflow(Request $request, $data, array $state)
    {
        return parent::buildWorkflow($request, $data['find'], $state);
    }

    public function processForm(Request $request, $form)
    {
        $clicked = $form->getClickedButton()->getName();
        $data = $form->getData();
        $find = $data['find'];
        $parameters['id'] = $find->id();
        $request->attributes->set('parameters', $parameters);
        if ($clicked == 'save') {
            $actor = Service::workflow()->actor();
            Service::workflow()->apply($actor, 'edit', $find);
            ORM::persist($find);
            ORM::flush($find);
            $request->attributes->set('flash', 'success');
            $request->attributes->set('message', 'dime.find.update.success');
            return;
        }
        if ($clicked == 'clone') {
            $request->attributes->set('redirect', 'finds.add');
            return;
        }
        if ($clicked == 'apply') {
            $actor = Service::workflow()->actor();
            $action = $form['find']['actions']->getNormData();
            $subject = $form['find']['actors']->getNormData();
            $action->apply($actor, $find, $subject);
            ORM::persist($find);
            ORM::flush($find);
            return;
        }
    }
}
