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
use ARK\ORM\ORM;
use ARK\Service;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImageController
{
    public function __invoke(Request $request, $server, $image) : Response
    {
        if ($server === 'file') {
            $file = ORM::find(Image::class, $image);
            $path = $file ? $file->path() : '';
        } else {
            $path = $server.'/'.$image;
            $server = 'assets';
        }
        try {
            if ($path) {
                return Service::imageResponse($server, $path, $request->query->all());
            }
        } catch (Exception $e) {
            $msg = $e->getMessage();
        }
        try {
            return Service::imageResponse('assets', 'icons/image.svg', $request->query->all());
        } catch (Exception $e) {
            throw new NotFoundHttpException($msg);
        }
    }
}
