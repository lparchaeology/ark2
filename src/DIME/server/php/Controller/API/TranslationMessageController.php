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

use ARK\Actor\Actor;
use ARK\Http\JsonResponse;
use ARK\Message\Message;
use ARK\ORM\ORM;
use ARK\Translation\Translation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TranslationMessageController
{
    public function __invoke(Request $request, string $keyword, string $role, string $language) : Response
    {
        try {
            $json = [];
            $translation = ORM::find(Translation::class, $keyword);
            if ($request->getMethod() === 'GET') {
                if (!$translation) {
                    $json['status'] = 'error';
                    $json['message'] = 'core.error.not.found';
                    return new JsonResponse($json);
                }
                $json['status'] = 'success';
                $json['keyword'] = $translation->keyword();
                $json['domain'] = $translation->domain()->id();
                $json['plural'] = $translation->isPlural();
                $json['parameters'] = [];
                foreach ($translation->parameters() as $parmameter) {
                    $json['parameters'][] = $parmameter->name();
                }
                if ($message = $translation->message($language, $role)) {
                    $json['message'] = $message->text();
                    $json['role'] = $message->role()->id();
                    $json['notes'] = $message->notes();
                } else {
                    $json['message'] = $keyword;
                    $json['role'] = $role;
                    $json['notes'] = '';
                }
            }
            if ($request->getMethod() === 'POST') {
                $content = json_decode($request->getContent(), true);
                if (!$translation) {
                    $translation = new Translation($keyword, $domain);
                    ORM::persist($translation);
                }
                $translation->setMessage($content['message'], $language, $role, $content['notes']);
                ORM::flush($translation);
                $json['status'] = 'success';
            }
        } catch (Exception $e) {
            $json['status'] = 'error';
            $json['code'] = $e->getCode();
            $json['message'] = $e->getMessage();
        }
        return new JsonResponse($json);
    }
}
