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

use ARK\ORM\ORM;
use ARK\Routing\Route;
use ARK\Service;
use ARK\View\Page;
use ARK\Workflow\Exception\WorkflowException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

abstract class PageController extends Controller
{
    public function handleRequest(Request $request) : Response
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
        $state = $page->buildState($data, $state);
        $options = $page->buildOptions($data, $state, []);
        $forms = ($page->content() ? $page->content()->buildForms($data, $state, $options) : null);
        if ($state['mode'] === 'deny') {
            throw new AccessDeniedException('core.error.access.denied');
        }
        if ($forms && $request->getMethod() === 'POST') {
            $parms = $request->request->all();
            $parms = $this->fixStaticFields($parms);
            $request->request->replace($parms);
            try {
                $posted = $this->postedForm($request, $forms);
                if ($posted !== null && $posted->isValid()) {
                    $this->processForm($request, $posted);
                    if ($file = $request->attributes->get('_file')) {
                        return Service::view()->fileResponse($file);
                    }
                    $redirect = $request->attributes->get('redirect') ?? $request->attributes->get('_route');
                    $parameters = $request->attributes->get('parameters') ?? [];
                    return Service::redirectPath($redirect, $parameters);
                }
                Service::view()->addErrorFlash('core.error.form.invalid');
		foreach ($posted->getErrors(true) as $error) {
		    $cause = $error->getCause()->getPropertyPath() . ' ' .(string) $error->getCause()->getCause()->getMessage();
                    Service::view()->addErrorFlash($error->getMessage().' '.$cause);
                }
            } catch (WorkflowException $e) {
                Service::view()->addErrorFlash($e->getMessage());
            }
        }
        $context = $page->pageContext($data, $state, $forms);
        $response = Service::view()->renderResponse($page->template(), $context);
        return $response;
    }

    public function buildState(Request $request, $data) : iterable
    {
        $state = parent::buildState($request, $data);
        $actor = $state['actor'];
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
        $state['routing']['base_path'] = $request->getBasePath();
        $state['routing']['routes'] = [];
        foreach (Service::routes() as $name => $route) {
            $state['routing']['routes'][$name] = [
                'host' => $route->getHost(),
                'path' => $route->getPath(),
                'schemes' => $route->getSchemes(),
                'requirements' => $route->getRequirements(),
                'condition' => $route->getCondition(),
            ];
        }
        return $state;
    }

    public function defaultOptions(string $route = null) : iterable
    {
        $options = parent::defaultOptions($route);
        $options['forms'] = null;
        return $options;
    }
}
