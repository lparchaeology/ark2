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
use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Group;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiController extends Controller
{
    public function handleRequest(Request $request) : Response
    {
        try {
            $content = json_decode($request->getContent());

            $group = ORM::find(Group::class, $request->attributes->get('_form'));

            $data = $this->buildData($request);
            $state = $this->buildState($request, $data);
            $state = array_replace_recursive($group->defaultState(), $state);
            $state['actor'] = Service::workflow()->actor();
            $options = $group->defaultOptions();

            $forms = $group->buildForms($data, $state, $options);
            $form = $forms[$group->formName()];
            if ($request->getMethod() === 'POST') {
                //$form->handleRequest($request);
                dump($form);
                $form->submit($request->request->get($form->getName()));
                dump($form);
                if ($form->isSubmitted() && $form->isValid()) {
                    $this->processForm($request, $form);
                    $data = $group->buildData($data, $state);
                    if ($status = $request->attributes->get('_status')) {
                        $json['status'] = $status;
                        $json['message'] = $request->attributes->get('_message');
                    } else {
                        $json['status'] = 'warning';
                        $json['message'] = 'core.form.process.unknown';
                    }
                } else {
                    dump($form);
                    dump($form->isSubmitted());
                    dump($form->isValid());
                    $json['status'] = 'error';
                    $json['message'] = 'core.form.validation.failed';
                    foreach ($form->getErrors(true) as $error) {
                        $json['errors'][] = $error->getMessage();
                    }
                    dump($json);
                }
            } else {
                $view = $form->createView();
                $json = $this->jsonView($view);
            }
        } catch (Throwable $e) {
            $json['status'] = $e->getCode();
            $json['message'] = $e->getMessage();
        }
        return new JsonResponse($json);
    }

    private function jsonView(FormView $view)
    {
        $json = [];
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
