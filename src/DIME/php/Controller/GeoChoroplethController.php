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

use ARK\Http\JsonResponse;
use ARK\Service;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class GeoChoroplethController
{
    public function __invoke(Request $request)
    {
        $content = json_decode($request->getContent());
        try {
            $concept = $content['concept'];
            $module = $content['module'];
            $attribute = (isset($content['attribute']) ? $content['attribute'] : null);
            $terms = Service::database()->getSpatialTermChoropleth($concept, $module, $attribute);
            $terms = array_column($terms, "count", "term");

            $curmax = 0;
            $curmin = inf;
            foreach ($terms as $term => $count) {
                $curmin = ($count < $curmin ?  $count : $curmin);
                $curmax = ($count > $curmax ?  $count : $curmax);
            }
            $band = ($curmax - $curmin) / 3;

            $data['concept'] = $concept;
            $data['count'] = count($terms);
            $data['max'] = $curmax;
            $data['min'] = $curmin;
            $data['terms'] = [];
            foreach ($terms as $term => $count) {
                $datum['term'] = $term;
                $datum['count'] = $count;
                if ($term['count'] == $curmin) {
                    $datum['band'] = 1;
                } elseif ($term['count'] < $curmin + $band) {
                    $datum['band'] = 2;
                } elseif ($term['count'] < $curmin + $band * 2) {
                    $datum['band'] = 3;
                } else {
                    $datum['band'] = 4;
                }
                $data['terms'][$term] = $datum;
            }
        } catch (Exception $e) {
            $data = [$e->getMessage()];
        }

        return new JsonResponse($data);
    }
}
