<?php

namespace ARK\Spatial\Exception;

use ARK\Spatial\Geometry\Geometry;

/**
 * Exception thrown when cordinate systems are mixed.
 */
class CoordinateSystemException extends GeometryException
{
    /**
     * @param Geometry $reference
     * @param Geometry $culprit
     *
     * @return CoordinateSystemException
     */
    public static function sridMix(Geometry $reference, Geometry $culprit) : CoordinateSystemException
    {
        return new self(sprintf(
            'SRID mix: %s with SRID %d cannot contain %s with SRID %d.',
            $reference->geometryType(),
            $reference->SRID(),
            $culprit->geometryType(),
            $culprit->SRID()
        ));
    }

    /**
     * @param Geometry $reference
     * @param Geometry $culprit
     *
     * @return CoordinateSystemException
     */
    public static function dimensionalityMix(Geometry $reference, Geometry $culprit) : CoordinateSystemException
    {
        return new self(sprintf(
            'Dimensionality mix: %s %s cannot contain %s %s.',
            $reference->geometryType(),
            $reference->coordinateSystem()->coordinateName(),
            $culprit->geometryType(),
            $culprit->coordinateSystem()->coordinateName()
        ));
    }
}
