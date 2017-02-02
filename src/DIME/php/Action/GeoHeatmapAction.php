<?php

/**
 * DIME Action
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

namespace DIME\Action;

use ARK\ORM\ORM;
use ARK\Service;
use ARK\Database\Database;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Brick\Geo\Point;

class GeoHeatmapAction
{
    public function __invoke(Request $request)
    {
        //get all the kommune
        $kommunes = Service::database()->getKommune();
        // get the counts of finds in kommune
        $findCounts = Service::database()->getHeatmap();
        //create a blank array to return
        $data = [];
        $curmax = 0;
        $curmin = INF;

        //this turns the 2D array of find counts into an array with keys
        $findCounts = array_column ( $findCounts , "count" , "fid" );
        
        foreach( $findCounts as $fid => $count ){
            if( $count < $curmin ){
                $curmin = $count;
            }
            if( $count > $curmax ){
                $curmax = $count;
            }
        }
        
        $band = ($curmax - $curmin)/3;
        
        foreach( $kommunes as $kommune ){
            // if the kommune has a count associate that with the geometry
            if (array_key_exists($kommune['fid'],$findCounts)){
                $kommune['count'] = $findCounts[$kommune['fid']];
                if( $kommune['count'] == $curmin ){
                    $kommune['band'] = 1;
                } else if( $kommune['count'] < $curmin+$band ){
                    $kommune['band'] = 2;
                } else if ( $kommune['count'] < $curmin+$band*2 ){
                    $kommune['band'] = 3;
                } else if ( $kommune['count'] < $curmin+$band*3 ){
                    $kommune['band'] = 4;
                } else {
                    $kommune['band'] = 4;
                }
            } else {
                //otherwise it is 0
                $kommune['count'] = "0";
                $kommune['band'] = 1;
            }
            // fill return array with these new kommune arrays
            $data['kommune'][] = $kommune;
        }
        
        $data['max'] = $curmax;
        $data['min'] = $curmin;
        
        //return it as json
        return new JsonResponse($data);
    }
}
