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

namespace DIME\Framework\Controller\View;

use ARK\Framework\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ErrorController
{
    public function __invoke(Application $app, Exception $e, Request $request, $code) : Response
    {
        // 404.html, or 40x.html, or 4xx.html, or error.html
        $dir = $app['dir.site'].'/templates/'.$config['web']['frontend'].'/errors/';
        $templates = [
            $dir.$code.'.html.twig',
            $dir.mb_substr($code, 0, 2).'x.html.twig',
            $dir.mb_substr($code, 0, 1).'xx.html.twig',
            $dir.'default.html.twig',
        ];
        return new Response($app['twig']->resolveTemplate($templates)->render(['code' => $code]), $code);
    }
}
