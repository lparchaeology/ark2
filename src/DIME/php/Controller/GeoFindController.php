<?php

/**
 * DIME Controller
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

namespace DIME\Controller;

use ARK\ORM\ORM;
use ARK\Service;
use ARK\Database\Database;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Brick\Geo\Point;
use Exception;
use ARK\Entity\Actor;
use ARK\Vocabulary\Term;

class GeoFindController
{
    public function __invoke(Request $request)
    {
        $wkt = $request->getContent();
        try {
            $point = Point::fromText($wkt);
            $id = Service::database()->getSpatialTermsContain('dime.denmark.kommune', $wkt, '4326');
            $kommune = ORM::find(Term::class, ['concept' => 'dime.denmark.kommune', 'term' => $id]);
            $id = Service::database()->getKommuneMuseum($id);
            $museum = ORM::find(Actor::class, $id);
            $data['in'] = $wkt;
            $data['x'] = $point->x();
            $data['y'] = $point->y();
            $data['kommune']['concept'] = $kommune->concept()->concept();
            $data['kommune']['term'] = $kommune->name();
            $data['kommune']['text'] = Service::translate($kommune->keyword());
            $data['museum']['item'] = $museum->id();
            $data['museum']['module'] = $museum->schema()->module()->name();
            $data['museum']['name'] = $museum->property('fullname')->value()[0]['content'];
        } catch (Exception $e) {
            $data = [$e->getMessage()];
        }
        return new JsonResponse($data);
    }
}
