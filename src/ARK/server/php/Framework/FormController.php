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

namespace ARK\Framework;

use ARK\Http\JsonResponse;
use ARK\View\Form;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class FormController extends Controller
{
    public function handleRequest(Request $request) : Response
    {
        try {
            $content = json_decode($request->getContent());

            $route = $this->route($request);
            $group = $route->view();

            $parent['data'] = $this->buildData($request);
            $parent['state'] = $this->buildState($request, $parent['data']);
            $parent['state'] = array_replace_recursive($group->defaultState(), $parent['state']);
            // TODO Set mode correctly!!!
            $parent['state']['mode'] = $group->mode();
            $parent['options'] = [];
            $view = $group->buildView($parent);
            if ($view['state']['mode'] === 'deny') {
                throw new AccessDeniedException('core.error.access.denied');
            }
            $forms = $group->buildForms($view);

            $json = [];
            if ($forms && $request->getMethod() === 'POST') {
                $parms = $request->request->all();
                $parms = $this->fixStaticFields($parms);
                $request->request->replace($parms);
                try {
                    $posted = $this->postedForm($request, $forms);
                    if ($posted !== null && $posted->isValid()) {
                        $this->processForm($request, $posted);
                        // RETURN data
                        if ($status = $request->attributes->get('_status')) {
                            $json['status'] = $status;
                            $json['message'] = $request->attributes->get('_message');
                        } else {
                            $json['status'] = 'warning';
                            $json['message'] = 'core.form.process.unknown';
                        }
                    } else {
                        $json['status'] = 'error';
                        $json['message'] = 'core.form.validation.failed';
                        foreach ($posted->getErrors(true) as $error) {
                            $json['errors'][] = $error->getMessage();
                        }
                    }
                } catch (WorkflowException $e) {
                    $json['status'] = $e->getCode();
                    $json['message'] = $e->getMessage();
                }
            } else {
                $form = $forms[$group->name()]->createView();
                $json = $this->jsonView($form);
            }
        } catch (Throwable $e) {
            $json['status'] = $e->getCode();
            $json['message'] = $e->getMessage();
        }
        //dump($json);
        return new JsonResponse($json);
    }

    private function jsonView(FormView $view, iterable $json = [])
    {
        if ($view->children) {
            foreach ($view as $name => $child) {
                $json = array_merge($json, $this->jsonView($child));
            }
        } else {
            $data = [];
            $data['id'] = $view->vars['id'];
            $data['name'] = $view->vars['name'];
            $data['full_name'] = $view->vars['full_name'];
            $data['value'] = $view->vars['value'];
            $json = [$data['id'] => $data];
        }
        return $json;
    }
}
