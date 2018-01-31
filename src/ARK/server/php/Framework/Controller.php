<?php

/**
 * ARK Abstract Controller.
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

namespace ARK\Framework;

use ARK\Model\Item;
use ARK\Routing\Route;
use ARK\Service;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller
{
    public function __invoke(Request $request) : Response
    {
        return $this->handleRequest($request);
    }

    abstract public function handleRequest(Request $request) : Response;

    protected function route(Request $request) : ?Route
    {
        return Route::find($request->attributes->get('_route'));
    }

    protected function buildData(Request $request)
    {
        return null;
    }

    protected function buildState(Request $request, $data) : iterable
    {
        $actor = Service::workflow()->actor();
        $state['actor'] = $actor;
        $item = $this->item($data);
        $state['workflow']['mode'] = $item ? Service::workflow()->mode($actor, $item) : 'edit';
        if ($item && $state['workflow']['mode'] === 'edit') {
            $state['actions'] = Service::workflow()->actionable($actor, $item);
            $state['actors'] = Service::workflow()->actors($actor, $item);
        }
        return $state;
    }

    protected function defaultOptions(string $route = null) : iterable
    {
        $options['data'] = null;
        $options['forms'] = null;
        return $options;
    }

    protected function buildContext(Request $request, iterable $view) : iterable
    {
        return $view;
    }

    protected function processForm(Request $request, Form $form) : void
    {
    }

    protected function item($data) : ?Item
    {
        return $data instanceof Item ? $data : null;
    }

    protected function fixStaticFields(iterable $parms) : iterable
    {
        foreach ($parms as $key => &$value) {
            if (is_iterable($value)) {
                $parms[$key] = $this->fixStaticFields($value);
            }
            if ($key === '_static') {
                $parms['static'] = null;
            }
        }
        return $parms;
    }

    protected function postedForm(Request $request, iterable $forms)
    {
        foreach ($forms as $id => $form) {
            if ($request->request->has($form->getName())) {
                $form->getRoot()->handleRequest($request);
                if ($form->isSubmitted()) {
                    return $form->getRoot();
                }
                return null;
            }
            if ($root = $this->postedForm($request, $form)) {
                return $root;
            }
        }
        return null;
    }
}
