<?php

namespace ARK\Spatial\IO;

use ARK\Spatial\Geometry\Geometry;

/**
 * Converter class from Geometry to WKT.
 */
class WKTWriter extends AbstractWKTWriter
{
    /**
     * {@inheritdoc}
     */
    public function write(Geometry $geometry) : string
    {
        return $this->doWrite($geometry);
    }
}
