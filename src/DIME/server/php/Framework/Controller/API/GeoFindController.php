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

use ARK\Actor\Museum;
use ARK\Service;
use ARK\Vocabulary\Term;
use Brick\Geo\Point;
use DIME\DIME;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GeoFindController
{
    public function __invoke(Request $request) : Response
    {
        $wkt = $request->getContent();
        try {
            $point = Point::fromText($wkt);
            $data['in'] = $wkt;
            $data['x'] = $point->x();
            $data['y'] = $point->y();
            $data['municipality'] = null;
            $data['museum'] = null;
            $municipality = DIME::findMunicipality($wkt);
            if ($municipality) {
                $data['municipality']['concept'] = $municipality->concept()->concept();
                $data['municipality']['term'] = $municipality->name();
                $data['municipality']['text'] = Service::translate($municipality->keyword());
                $museum = DIME::getMunicipalityMuseum($municipality->name());
                if ($museum) {
                    $data['museum']['id'] = $museum->id();
                    $data['museum']['module'] = $museum->schema()->module()->id();
                    $data['museum']['name'] = $museum->property('fullname')->value()->content();
                }
            }
        } catch (\Throwable $e) {
            $data = [$e->getMessage()];
        }
        return new JsonResponse($data);
    }
}
