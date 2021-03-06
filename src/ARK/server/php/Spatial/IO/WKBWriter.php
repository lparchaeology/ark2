<?php

namespace ARK\Spatial\IO;

use ARK\Spatial\Geometry\Geometry;

/**
 * Writes geometries in the WKB format.
 */
class WKBWriter extends AbstractWKBWriter
{
    /**
     * {@inheritdoc}
     */
    protected function packHeader(Geometry $geometry, bool $outer) : string
    {
        $geometryType = $geometry->geometryCode();

        $cs = $geometry->coordinateSystem();

        if ($cs->hasZ()) {
            $geometryType += 1000;
        }

        if ($cs->hasM()) {
            $geometryType += 2000;
        }

        return $this->packUnsignedInteger($geometryType);
    }
}
