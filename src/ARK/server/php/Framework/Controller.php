<?php

/**
 * ARK Controller.
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
use ARK\ORM\ORM;
use ARK\Routing\Route;
use ARK\Service;
use ARK\View\Page;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

abstract class Controller
{
    public function __invoke(Request $request)
    {
        return $this->handleRequest($request);
    }

    public function handleRequest(Request $request)
    {
        $route = ORM::find(Route::class, $request->attributes->get('_route'));
        if ($route) {
            $page = $route->page();
            if ($route->redirect()) {
                $request->attributes->set('redirect', $route->redirect()->id());
            }
        } else {
            $page = ORM::find(Page::class, $request->attributes->get('page'));
        }
        $data = $this->buildData($request);
        $state = $this->buildState($request, $data);
        return $page->handleRequest($request, $data, $state, [$this, 'processForm']);
    }

    public function buildData(Request $request)
    {
        return null;
    }

    public function buildState(Request $request, $data) : iterable
    {
        $actor = Service::workflow()->actor();
        $state['actor'] = $actor;
        $item = $this->item($data);
        $state['workflow']['mode'] = $item ? Service::workflow()->mode($actor, $item) : 'view';
        if ($item && $state['workflow']['mode'] === 'edit') {
            $state['actions'] = Service::workflow()->updateActions($actor, $item);
            $select['choice_value'] = 'name';
            $select['choice_name'] = 'name';
            $select['choice_label'] = 'keyword';
            $select['choices'] = $state['actions'];
            $select['multiple'] = false;
            $select['placeholder'] = Service::translate('core.placeholder');
            $state['select']['actions'] = $select;

            $state['actors'] = Service::workflow()->actors($actor, $item);
            $select['choice_value'] = 'id';
            $select['choice_name'] = 'id';
            $select['choice_label'] = 'fullname';
            $select['choices'] = $state['actors'];
            $select['multiple'] = false;
            $select['placeholder'] = Service::translate('core.placeholder');
            $state['select']['actors'] = $select;
        }
        return $state;
    }

    public function processForm(Request $request, Form $form) : void
    {
    }

    public function defaultOptions(string $route = null) : iterable
    {
        $options['mode'] = 'view';
        $options['data'] = null;
        $options['forms'] = null;
        return $options;
    }

    protected function item($data) : ?Item
    {
        if ($data instanceof Item) {
            return $data;
        }
        return null;
    }
}
