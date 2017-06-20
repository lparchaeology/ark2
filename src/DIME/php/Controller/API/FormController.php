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

namespace DIME\Controller\API;

use ARK\Http\JsonResponse;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Group;
use Symfony\Component\HttpFoundation\Request;

class FormController
{
    public function handleRequest(Request $request)
    {
        try {
            $data = $this->processRequest($request);
        } catch (Exception $e) {
            $data['error']['code'][$e->getCode()];
            $data['error']['message'][$e->getMessage()];
        }
        return new JsonResponse($data);
    }

    protected function processRequest(Request $request)
    {
        $content = json_decode($request->getContent());
        dump($content);
        $state = $content['state'];

        $group = ORM::find(Group::class, $request->attributes->get('form'));

        $state = array_replace_recursive($group->defaultState(), $state);
        $state['actor'] = Service::workflow()->actor();

        $data = $group->buildData($data, $state);
        $options = $group->defaultOptions();

        $forms = $group->buildForms($data, $state, $options);
        $form = $forms[$name];
        if ($request->getMethod() == 'POST') {
            $this->processForm($request, $form);
            $data = $group->buildData($data, $state);
            if ($flash = $request->attributes->get('flash')) {
                $state['flash'] = $flash;
                $state['message'] = $request->attributes->get('message');
            }
            $parameters = ($request->attributes->get('parameters') ?: []);
        }
        $view = $form->createView();
        dump($view);
        return $view;
    }

    public function buildData(Request $request)
    {
        $data = null;
        return $data;
    }

    public function processForm(Request $request, $form)
    {
        return null;
    }
}
