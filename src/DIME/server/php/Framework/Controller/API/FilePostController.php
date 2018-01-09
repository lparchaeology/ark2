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

namespace DIME\Framework\Controller\API;

use ARK\File\File;
use ARK\ORM\ORM;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Image;

class FilePostController
{
    public function __invoke(Request $request) : Response
    {
        $ids = [];
        // TODO Make generic, file widget should set properly
        $files = $this->flatten($request->files->all());
        // TODO Naive error handling, make constraint generic somehow
        $validator = Validation::createValidator();
        $constraint = new Image();
        $errors = [];
        foreach ($files as $upload) {
            $violations = $validator->validate($upload, $constraint);
            foreach ($violations as $violation) {
                $error['code'] = $violation->getCode();
                $error['source'] = $upload->getClientOriginalName();
                $error['detail'] = $violation->getMessage();
                $errors[] = $error;
            }
        }
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => $errors]);
        }
        foreach ($files as $upload) {
            $file = File::createFromUploadedFile($upload);
            if ($file) {
                ORM::persist($file);
                $ids[] = $file->id();
            }
        }
        ORM::flush(File::class);
        return new JsonResponse($ids);
    }

    private function flatten($input) : array
    {
        if (!is_array($input)) {
            return [$input];
        }
        return array_reduce(
            $input,
            function ($c, $a) {
                return array_merge($c, $this->flatten($a));
            },
            []
        );
    }
}
