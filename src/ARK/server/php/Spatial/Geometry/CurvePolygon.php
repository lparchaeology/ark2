<?php

namespace ARK\Spatial;

use ARK\Spatial\Exception\CoordinateSystemException;
use ARK\Spatial\Exception\EmptyGeometryException;
use ARK\Spatial\Exception\NoSuchGeometryException;

/**
 * A CurvePolygon is a planar Surface defined by 1 exterior boundary and 0 or more interior boundaries.
 *
 * A CurvePolygon instance differs from a Polygon instance in that a CurvePolygon instance may contain
 * the following circular arc segments: CircularString and CompoundCurve in addition to LineString.
 */
class CurvePolygon extends Surface
{
    /**
     * Class constructor.
     *
     * The coordinate system of each of the rings must match the one of the CurvePolygon.
     *
     * @param CoordinateSystem $cs       the coordinate system of the CurvePolygon
     * @param Curve            ...$rings The rings that compose the CurvePolygon.
     *
     * @throws CoordinateSystemException if different coordinate systems are used
     */
    public function __construct(CoordinateSystem $cs, Curve ...$rings)
    {
        $this->init(Geometry::CURVEPOLYGON, $cs, $rings ?? []);
    }

    /**
     * Creates a non-empty CurvePolygon composed of the given rings.
     *
     * @param Curve $exteriorRing     the exterior ring
     * @param Curve ...$interiorRings The interior rings, if any.
     *
     * @throws CoordinateSystemException if the rings use different coordinate systems
     * @return CurvePolygon
     */
    public static function of(Curve $exteriorRing, Curve ...$interiorRings) : CurvePolygon
    {
        return new static($exteriorRing->coordinateSystem(), $exteriorRing, ...$interiorRings);
    }

    /**
     * Returns the exterior ring of this CurvePolygon.
     *
     * @throws EmptyGeometryException
     * @return Curve
     */
    public function exteriorRing() : Curve
    {
        if ($this->isEmpty) {
            throw new EmptyGeometryException('An empty CurvePolygon has no exterior ring.');
        }
        return $this->element(0);
    }

    /**
     * Returns the number of interior rings in this CurvePolygon.
     *
     * @return int
     */
    public function numInteriorRings() : int
    {
        return $this->isEmpty() ? 0 : $this->count() - 1;
    }

    /**
     * Returns the specified interior ring N in this CurvePolygon.
     *
     * @param int $n the ring number, 1-based
     *
     * @throws NoSuchGeometryException if there is no interior ring at this index
     * @return Curve
     */
    public function interiorRingN(int $n) : Curve
    {
        if ($n <= 0) {
            throw new NoSuchGeometryException('There is no interior ring in this CurvePolygon at index '.$n);
        }
        return $this->element($n + 1);
    }
}
