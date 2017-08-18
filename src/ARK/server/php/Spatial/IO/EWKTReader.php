<?php

namespace ARK\Spatial\IO;

use ARK\Spatial\Exception\GeometryIOException;
use ARK\Spatial\Geometry\Geometry;

/**
 * Reads geometries from the Extended WKT format designed by PostGIS.
 */
class EWKTReader extends AbstractWKTReader
{
    /**
     * @param string $ewkt the EWKT to read
     *
     * @throws GeometryIOException
     * @return Geometry
     */
    public function read($ewkt) : Geometry
    {
        $parser = new EWKTParser(strtoupper($ewkt));
        $srid = $parser->getOptionalSRID();
        $geometry = $this->readGeometry($parser, $srid);

        if (!$parser->isEndOfStream()) {
            throw GeometryIOException::invalidEWKT();
        }

        return $geometry;
    }
}
