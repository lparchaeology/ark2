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
use Symfony\Component\HttpFoundation\Request;

class FormController
{
    public function __invoke(Request $request)
    {
        $content = json_decode($request->getContent());
        try {
            $state = $content['state'];
            $this->handleRequest($request, $state);
        } catch (Exception $e) {
            $data['error']['code'][$e->getCode()];
            $data['error']['message'][$e->getMessage()];
        }
        return new JsonResponse($data);
    }

    public function handleRequest(Request $request, array $state, array $formData, $redirect = null)
    {
        $state = $this->buildState($request, $state);
        $data = $this->buildData($request, $state['slugs']);
        $options = $page->buildOptions($data, ['state' => $state]);
        $options = $page->buildOptions($data, $options);
        $layout = $page->content;
        $forms = $layout->buildForms($data, $options);


        $options['state']['layout'] = $layout;
        if ($layout->label !== null) {
            $options['state']['label'] = $layout->label;
        }
        if ($layout->required === false) {
            $options['state']['required'] = $layout->required;
        }
        $data = $layout->formData($data, $options['state']);
        $options = $layout->buildOptions($data, $options);
        $builder = $layout->formBuilder($data, $options, ($layout->name ? null : false));


        $options['state']['mode'] = $layout->displayMode($options['state']['mode']);
        $data = $layout->formData($data, $options['state']);
        //dump($data);
        $options = $layout->buildOptions($data, $options);
        $options['state']['layout'] = $layout;
        if ($layout->label !== null) {
            $options['state']['label'] = $layout->label;
        }
        if ($layout->required === false) {
            $options['state']['required'] = $layout->required;
        }
        foreach ($layout->cells() as $cell) {
            $cell->buildForm($builder, $data, $dataKey, $options);
        }


        $form = $builder->getForm();
        $forms = [$layout->formName() => $form];


        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                if (!$redirect) {
                    $redirect = $request->attributes->get('_route');
                }
                return $this->processForm($request, $posted, $redirect);
            }
        }

        $context['state'] = $options['state'];
        $response = $this->renderResponse($data, $context, $forms);
        return $response;
    }

    public function buildData(Request $request, $slugs = [])
    {
        $data = null;
        return $data;
    }

    public function buildState(Request $request, $state)
    {
        $state['actor'] = Service::workflow()->actor();
        return $state;
    }

    public function processForm(Request $request, $form, $redirect)
    {
        return Service::redirectPath($redirect);
    }
}
