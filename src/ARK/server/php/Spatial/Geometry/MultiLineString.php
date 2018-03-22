<?php

namespace ARK\Spatial\Geometry;

/**
 * A MultiLineString is a MultiCurve whose elements are LineStrings.
 */
class MultiLineString extends MultiCurve
{
    /**
     * Class constructor.
     *
     * @param CoordinateSystem $cs
     * @param LineString       ...$linestrings
     *
     * @throws CoordinateSystemException   if different coordinate systems are used
     * @throws UnexpectedGeometryException if a geometry is not a valid type for a sub-class of GeometryCollection
     */
    public function __construct(CoordinateSystem $cs, LineString ...$linestrings)
    {
        $this->init(Geometry::MULTILINESTRING, $cs, $linestrings ?? []);
    }
}
