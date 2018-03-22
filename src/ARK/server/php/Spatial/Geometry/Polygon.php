<?php

namespace ARK\Spatial\Geometry;

use ARK\Spatial\Exception\CoordinateSystemException;
use ARK\Spatial\Exception\EmptyGeometryException;
use ARK\Spatial\Exception\InvalidGeometryException;

/**
 * {@inheritdoc}
 */
class Polygon extends Surface implements PolygonInterface
{
    /**
     * Class constructor.
     *
     * The coordinate system of each of the rings must match the one of the Polygon.
     *
     * @param CoordinateSystem $cs       the coordinate system of the Polygon
     * @param LineString       ...$rings The rings that compose the Polygon, the first one being the exterior ring.
     *
     * @throws InvalidGeometryException  if the resulting geometry is not valid for a sub-type of Polygon
     * @throws CoordinateSystemException if different coordinate systems are used
     */
    public function __construct(CoordinateSystem $cs, LineString ...$rings)
    {
        $this->init(Geometry::POLYGON, $cs, $rings ?? []);
    }

    /**
     * Creates a non-empty Polygon composed of the given rings.
     *
     * @param LineString $exteriorRing     the exterior ring
     * @param LineString ...$interiorRings The interior rings, if any.
     *
     * @throws InvalidGeometryException  if the resulting geometry is not valid for a sub-type of Polygon
     * @throws CoordinateSystemException if the rings use different coordinate systems
     * @return Polygon
     */
    public static function of(LineString $exteriorRing, LineString ...$interiorRings) : Polygon
    {
        return new static($exteriorRing->coordinateSystem(), $exteriorRing, ...$interiorRings);
    }

    /**
     * {@inheritdoc}
     */
    public function exteriorRing() : LineString
    {
        if ($this->isEmpty) {
            throw new EmptyGeometryException('An empty Polygon has no exterior ring.');
        }
        return $this->element(0);
    }

    /**
     * {@inheritdoc}
     */
    public function numInteriorRings() : int
    {
        return $this->isEmpty ? 0 : $this->count() - 1;
    }

    /**
     * {@inheritdoc}
     */
    public function interiorRingN(int $n) : LineString
    {
        return $this->element($n + 1);
    }
}
