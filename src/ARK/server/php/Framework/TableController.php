<?php

/**
 * API Table Controller.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
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
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Framework;

use ARK\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class FormController extends Controller
{
    public function handleRequest(Request $request) : Response
    {
        try {
            $query = $request->query->all();
            $content = json_decode($request->getContent());

            $route = $this->route($request);
            $table = $route->view();

            $parent['data'] = $this->buildData($request);
            $parent['state'] = $this->buildState($request, $parent['data']);
            $parent['state'] = array_replace_recursive($table->defaultState(), $parent['state']);
            // TODO Set mode correctly!!!
            $parent['state']['mode'] = $table->mode();
            $parent['options'] = [];
            $view = $table->buildView($parent);
            if ($view['state']['mode'] === 'deny') {
                throw new AccessDeniedException('core.error.access.denied');
            }

            $json = [];
        } catch (Throwable $e) {
            $json['status'] = $e->getCode();
            $json['message'] = $e->getMessage();
        }
        //dump($json);
        return new JsonResponse($json);
    }
}
