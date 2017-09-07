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
namespace DIME\Controller\API;

use ARK\File\File;
use ARK\ORM\ORM;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FilePostController {
    public function __invoke(Request $request): Response
    {
        $ids = [ ];
        foreach ( $request->files as $upload ) {
            if (array_key_exists ( 'image', $upload )) {
                $uploadFile = $upload ['image'] ['file'] [0];
            } else if (array_key_exists ( 'avatar', $upload )) {
                $uploadFile = $upload ['avatar'] ['file'];
            }

            if ($file = File::createFromUploadedFile ( $uploadFile )) {
                ORM::persist ( $file );
                ORM::flush ( $file );
                $ids [] = $file->id ();
            }
        }

        return new JsonResponse ( $ids );
    }
}
