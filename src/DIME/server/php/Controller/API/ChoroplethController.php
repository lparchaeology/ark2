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

use ARK\Service;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ChoroplethController
{
    public function __invoke(Request $request) : Response
    {
        // get all the municipality
        $municipalities = Service::database()->getSpatialTerms('dime.denmark.municipality', 'choropleth');

        // get the counts of finds in municipality
        $itemlist = $request->query->get('itemlist');

        $findCounts = Service::database()->getSpatialTermChoropleth('dime.denmark.municipality', 'find', 'location', $itemlist ?? []);
        // create a blank array to return
        $data = [];
        $curmax = 0;
        $curmin = INF;

        if (count($findCounts) === 0) {
            $curmax = 0;
            $curmin = 0;
        } else {
            // this turns the 2D array of find counts into an array with keys
            $findCounts = array_column($findCounts, 'count', 'term');

            foreach ($findCounts as $term => $count) {
                if ($count < $curmin) {
                    $curmin = $count;
                }
                if ($count > $curmax) {
                    $curmax = $count;
                }
            }

            // if the min and max are the same set the min to 0 so all municipalities are maximum
            // if there are not counts for all the municipalities some will be 0, so that is the minimum
            if ($curmin === $curmax || count($findCounts) !== count($municipalities)) {
                $curmin = 0;
            }
        }

        $band = ($curmax - $curmin) / 3;

        foreach ($municipalities as $municipality) {
            // if the municipality has a count associate that with the geometry
            if (array_key_exists($municipality['term'], $findCounts)) {
                $municipality['count'] = $findCounts[$municipality['term']];
                if ($municipality['count'] === $curmin) {
                    $municipality['band'] = 1;
                } elseif ($municipality['count'] <= $curmin + $band) {
                    $municipality['band'] = 2;
                } elseif ($municipality['count'] <= $curmin + $band * 2) {
                    $municipality['band'] = 3;
                } elseif ($municipality['count'] <= $curmin + $band * 3) {
                    $municipality['band'] = 4;
                } else {
                    $municipality['band'] = 4;
                }
            } else {
                // otherwise it is 0
                $municipality['count'] = '0';
                $municipality['band'] = 1;
            }
            // fill return array with these new municipality arrays
            $data['municipality'][] = $municipality;
        }

        $data['max'] = $curmax;
        $data['min'] = $curmin;

        // return it as json
        return new JsonResponse($data);
    }
}
