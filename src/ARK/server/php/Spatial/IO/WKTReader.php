<?php

namespace ARK\Spatial\IO;

use ARK\Spatial\Exception\GeometryIOException;
use ARK\Spatial\Geometry;

/**
 * Builds geometries out of Well-Known Text strings.
 */
class WKTReader extends AbstractWKTReader
{
    /**
     * @param string  $wkt  The WKT to read.
     * @param integer $srid The optional SRID of the geometry.
     *
     * @return Geometry
     *
     * @throws GeometryIOException
     */
    public function read($wkt, $srid = 0)
    {
        $parser = new WKTParser(strtoupper($wkt));
        $geometry = $this->readGeometry($parser, $srid);

        if (! $parser->isEndOfStream()) {
            throw GeometryIOException::invalidWKT();
        }

        return $geometry;
    }
}
