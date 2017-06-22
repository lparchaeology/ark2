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

use ARK\View\Page;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Vocabulary\Term;
use DIME\DIME;
use DIME\Controller\View\DimeFormController;
use DIME\Entity\Find;
use Symfony\Component\HttpFoundation\Request;

class FindAddController extends DimeFormController
{
    public function __invoke(Request $request)
    {
        $request->attributes->set('page', 'dime_page_find_add');
        $request->attributes->set('redirect', 'finds.view');
        return $this->handleRequest($request);
    }

    public function buildData(Request $request)
    {
        $actor = Service::workflow()->actor();
        $find = new Find('dime.find');
        $find->property('finder')->setValue($actor);
        $data['find'] = $find;
        return $data;
    }

    public function buildWorkflow(Request $request, $data, array $state)
    {
        return parent::buildWorkflow($request, $data['find'], $state);
    }

    public function processForm(Request $request, $form)
    {
        $find = $form->getData();
        $actor = Service::workflow()->actor();
        Service::workflow()->apply($actor, 'record', $find);
        ORM::persist($find);
        ORM::flush($find);
        $parameters['id'] = $find->id();
        $request->attributes->set('parameters', $parameters);
        $request->attributes->set('flash', 'success');
        $request->attributes->set('message', 'dime.find.add.success');
    }
}
