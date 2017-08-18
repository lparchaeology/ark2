<?php

namespace ARK\Spatial\IO;

use ARK\Spatial\Exception\GeometryIOException;
use ARK\Spatial\Geometry\Geometry;

/**
 * Builds geometries out of Well-Known Binary strings.
 */
class WKBReader extends AbstractWKBReader
{
    /**
     * @param string $wkb  the WKB to read
     * @param int    $srid the optional SRID of the geometry
     *
     * @throws GeometryIOException
     * @return Geometry
     */
    public function read(string $wkb, int $srid = 0) : Geometry
    {
        $buffer = new WKBBuffer($wkb);
        $geometry = $this->readGeometry($buffer, $srid);

        if (!$buffer->isEndOfStream()) {
            throw GeometryIOException::invalidWKB('unexpected data at end of stream');
        }

        return $geometry;
    }

    /**
     * {@inheritdoc}
     */
    protected function readGeometryHeader(WKBBuffer $buffer, int &$geometryType, bool &$hasZ, bool &$hasM, bool &$srid) : void
    {
        $wkbType = $buffer->readUnsignedLong();

        $geometryType = $wkbType % 1000;
        $dimension = ($wkbType - $geometryType) / 1000;

        if ($dimension < 0 || $dimension > 3) {
            throw GeometryIOException::unsupportedWKBType($wkbType);
        }

        $hasZ = ($dimension === 1 || $dimension === 3);
        $hasM = ($dimension === 2 || $dimension === 3);
    }
}
