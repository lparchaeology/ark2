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

use ARK\Framework\ApiController;
use ARK\Model\Item;
use ARK\ORM\ORM;
use DIME\DIME;
use DIME\Entity\Museum;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MuseumController extends ApiController
{
    public function __invoke(Request $request) : Response
    {
        $request->attributes->set('_form', 'dime_museum_form');
        return $this->handleRequest($request);
    }

    public function buildData(Request $request)
    {
        $museum = $request->attributes->get('id');
        $data['museum'] = ORM::find(Museum::class, $museum);
        return $data;
    }

    public function buildState(Request $request, $data) : iterable
    {
        $state = parent::buildState($request, $data);
        $state['image'] = 'avatar';
        return $state;
    }

    public function processForm(Request $request, Form $form) : void
    {
        $id = $request->attributes->get('id');
        $submitted = $form->getConfig()->getName();
        if ($submitted === 'museum') {
            $museum = $form->getData();
            ORM::flush($museum);
            $request->attributes->set('_status', 'success');
            $request->attributes->set('_message', 'dime.admin.museum.updated');
        }
    }

    protected function item($data) : ?Item
    {
        return $data['museum'];
    }
}
