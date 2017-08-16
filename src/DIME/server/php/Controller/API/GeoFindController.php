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
 * @php        >=5.6, >=7.0
 */

namespace DIME\Controller\API;

use ARK\Actor\Museum;
use ARK\Database\Database;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Vocabulary\Term;
use Brick\Geo\Point;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GeoFindController
{
    public function __invoke(Request $request)
    {
        $wkt = $request->getContent();
        try {
            $point = Point::fromText($wkt);
            $data['in'] = $wkt;
            $data['x'] = $point->x();
            $data['y'] = $point->y();
            $mid = Service::database()->getSpatialTermsContain('dime.denmark.municipality', $wkt, '4326');
            if ($mid) {
                $mid = $mid[0]['term'];

                $municipality = ORM::find(Term::class, ['concept' => 'dime.denmark.municipality', 'term' => $mid]);
                if ($municipality) {
                    $data['municipality']['concept'] = $municipality->concept()->concept();
                    $data['municipality']['term'] = $municipality->name();
                    $data['municipality']['text'] = Service::translate($municipality->keyword());
                }

                $id = Service::database()->getMunicipalityMuseum($mid);
                if ($id) {
                    $museum = ORM::find(Museum::class, $id[0]['item']);
                    $data['museum']['item'] = $museum->id();
                    $data['museum']['module'] = $museum->schema()->module()->name();
                    $data['museum']['name'] = $museum->property('fullname')->value()->content();
                }
            }
        } catch (Exception $e) {
            $data = [$e->getMessage()];
        }
        return new JsonResponse($data);
    }
}
