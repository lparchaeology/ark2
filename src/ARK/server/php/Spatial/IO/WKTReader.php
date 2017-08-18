<?php

namespace ARK\Spatial\IO;

use ARK\Spatial\Exception\GeometryIOException;
use ARK\Spatial\Geometry\Geometry;

/**
 * Builds geometries out of Well-Known Text strings.
 */
class WKTReader extends AbstractWKTReader
{
    /**
     * @param string $wkt  the WKT to read
     * @param int    $srid the optional SRID of the geometry
     *
     * @throws GeometryIOException
     * @return Geometry
     */
    public function read(string $wkt, int $srid = 0) : Geometry
    {
        $parser = new WKTParser(strtoupper($wkt));
        $geometry = $this->readGeometry($parser, $srid);

        if (!$parser->isEndOfStream()) {
            throw GeometryIOException::invalidWKT();
        }

        return $geometry;
    }
}
