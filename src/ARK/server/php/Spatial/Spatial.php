<?php

/**
 * ARK Spatial.
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

namespace ARK\Spatial;

use ARK\Service;
use ARK\Spatial\Engine\GeometryEngineInterface;
use ARK\Spatial\Engine\GEOSEngine;
use ARK\Spatial\Engine\PDOEngine;
use ARK\Spatial\Engine\SpatialiteEngine;

class Spatial
{
    // Note this is done as a static call to allow for later splitting out into standalone library
    public static function geometry() : GeometryEngineInterface
    {
        if (self::geometry === null) {
            $engine = Service::config()['spatial']['driver'];
            if ($engine === 'geos') {
                self::$geometry = new GEOSEngine();
            } elseif ($engine === 'spatialite') {
                // TODO copy config
                self::$geometry = new SpatiaLiteEngine();
            } elseif ($engine === 'postgis' || $engine === 'mysql') {
                $conn = Service::database()->spatial()->getWrappedConnection();
                self::$geometry = new PDOEngine($conn);
            }
            // TODO Else throw exception
        }
        return self::geometry;
    }
}
