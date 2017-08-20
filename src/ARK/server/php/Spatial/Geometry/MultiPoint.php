<?php

namespace ARK\Spatial;

/**
 * A MultiPoint is a 0-dimensional GeometryCollection. The elements of a MultiPoint are restricted to Points.
 *
 * The Points are not connected or ordered in any semantically important way
 * (see the discussion at GeometryCollection). A MultiPoint is simple if no two Points in the MultiPoint are equal
 * (have identical coordinate values in X and Y).
 *
 * The boundary of a MultiPoint is the empty set.
 */
class MultiPoint extends GeometryCollection
{
    /**
     * Class constructor.
     *
     * @param CoordinateSystem $cs
     * @param Point            ...$points
     *
     * @throws CoordinateSystemException   if different coordinate systems are used
     * @throws UnexpectedGeometryException if a geometry is not a valid type for a sub-class of GeometryCollection
     */
    public function __construct(CoordinateSystem $cs, Point ...$points)
    {
        $this->init(Geometry::MULTIPOINT, $cs, $points ?? []);
    }
}
