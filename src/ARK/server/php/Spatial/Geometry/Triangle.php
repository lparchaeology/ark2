<?php

namespace ARK\Spatial\Geometry;

use ARK\Spatial\Exception\InvalidGeometryException;

/**
 * A Triangle is a Polygon with 3 distinct, non-collinear vertices and no interior boundary.
 */
class Triangle extends Polygon
{
    /**
     * {@inheritdoc}
     */
    public function __construct(CoordinateSystem $cs, LineString ...$rings)
    {
        $this->init(Geometry::TRIANGLE, $cs, $rings ?? []);
    }

    /**
     * {@inheritdoc}
     */
    protected function validate() : void
    {
        if ($this->exteriorRing()->numPoints() !== 4) {
            throw new InvalidGeometryException('A triangle must have exactly 4 (3 + 1) points.');
        }

        if ($this->numInteriorRings() !== 0) {
            throw new InvalidGeometryException('A triangle must not have interior rings.');
        }
    }
}
