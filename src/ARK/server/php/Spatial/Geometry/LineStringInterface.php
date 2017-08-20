<?php

namespace ARK\Spatial\Geometry;

/**
 * A LineString is a Curve with linear interpolation between Points.
 *
 * Each consecutive pair of Points defines a line segment.
 */
interface LineStringInterface
{
    /**
     * Returns the number of Points in this LineString.
     *
     * @return int
     */
    public function numPoints() : int;

    /**
     * Returns the specified Point N in this LineString.
     *
     * @param int $n the point number, 1-based
     *
     * @throws NoSuchGeometryException if there is no Point at this index
     * @return Point
     */
    public function pointN(int $n) : Point;
}
