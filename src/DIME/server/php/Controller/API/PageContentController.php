<?php

/**
 * DIME Controller.
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

namespace DIME\Controller\API;

use ARK\Entity\Page;
use ARK\Http\JsonResponse;
use ARK\Message\Message;
use ARK\ORM\ORM;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class PageContentController
{
    public function __invoke(Request $request) : Response
    {
        try {
            $input = json_decode($request->getContent(), true);
            $page = ORM::find(Page::class, $input['route']);
            $json = [];
            if ($page === null) {
                $json['error']['code'] = 404;
                $json['error']['message'] = 'Route not found';
                $json['error']['content'] = $input;
            } elseif ($request->getMethod() === 'GET') {
                $json['route'] = $input['route'];
                $json['content'] = $page->value('content');
            } elseif ($request->getMethod() === 'POST') {
                $content = $page->value('content');
                $content->setContent($input['content']);
                $page->setValue('content', $content);
                ORM::flush($page);
                $json['status'] = 'success';
            }
        } catch (Throwable $e) {
            $json['error']['code'] = $e->getCode();
            $json['error']['message'] = $e->getMessage();
            $json['error']['content'] = $input;
        }
        return new JsonResponse($json);
    }
}
