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

use ARK\File\Image;
use ARK\Service;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ImageController
{
    public function __invoke(Request $request) : Response
    {
        $server = $request->attributes->get('server');
        $image = $request->attributes->get('image');
        $path = 'brand/logo.png';
        try {
            if ($server === 'file') {
                $file = Image::find($image);
                if ($file) {
                    $actor = Service::workflow()->actor();
                    if ($file->visibility()->name() === 'public' || Service::workflow()->can($actor, 'view', $file)) {
                        $path = $file->path();
                    }
                } else {
                    $server = 'assets';
                }
            } else {
                $path = $server.'/'.$image;
                $server = 'assets';
            }
            $response = Image::response($server, $path, $request->query->all());
            return $response;
        } catch (Throwable $e) {
            $msg = $e->getMessage();
            throw new NotFoundHttpException($msg);
        }
    }
}
