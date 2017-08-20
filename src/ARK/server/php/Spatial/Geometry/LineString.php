<?php

namespace ARK\Spatial;

use ARK\Spatial\Exception\CoordinateSystemException;
use ARK\Spatial\Exception\InvalidGeometryException;
use ARK\Spatial\Exception\NoSuchGeometryException;

/**
 * A LineString is a Curve with linear interpolation between Points.
 *
 * Each consecutive pair of Points defines a line segment.
 */
class LineString extends Curve implements LineStringInterface
{
    /**
     * Class constructor.
     *
     * A LineString must be composed of 2 points or more, or 0 points for an empty LineString.
     * A LineString with exactly 1 point is not allowed.
     *
     * The coordinate system of each of the points must match the one of the LineString.
     *
     * @param CoordinateSystem $cs        the coordinate system of the LineString
     * @param Point            ...$points The points that compose the LineString.
     *
     * @throws InvalidGeometryException  if only one point was given
     * @throws CoordinateSystemException if different coordinate systems are used
     */
    public function __construct(CoordinateSystem $cs, Point ...$points)
    {
        $this->init(Geometry::LINESTRING, $cs, $points ?? []);
    }

    /**
     * Creates a non-empty LineString composed of the given points.
     *
     * @param Point $point1    the first point
     * @param Point ...$pointN The subsequent points.
     *
     * @throws InvalidGeometryException  if only one point was given
     * @throws CoordinateSystemException if the points use different coordinate systems
     * @return LineString
     */
    public static function of(Point $point1, Point ...$pointN) : LineString
    {
        return new self($point1->coordinateSystem(), $point1, ...$pointN);
    }

    /**
     * Creates a rectangle out of two 2D corner points.
     *
     * The result is a linear ring (closed and simple).
     *
     * @param Point $a
     * @param Point $b
     *
     * @throws CoordinateSystemException if the points use different coordinate systems, or are not 2D
     * @return LineString
     */
    public static function extent(Point $a, Point $b) : LineString
    {
        $cs = $a->coordinateSystem();

        if ($cs !== $b->coordinateSystem()) { // by-value comparison.
            throw CoordinateSystemException::dimensionalityMix($a, $b);
        }

        if ($cs->coordinateDimension() !== 2) {
            throw new CoordinateSystemException(__METHOD__.' expects 2D points.');
        }

        $x1 = min($a->x(), $b->x());
        $x2 = max($a->x(), $b->x());

        $y1 = min($a->y(), $b->y());
        $y2 = max($a->y(), $b->y());

        $p1 = new Point($cs, $x1, $y1);
        $p2 = new Point($cs, $x2, $y1);
        $p3 = new Point($cs, $x2, $y2);
        $p4 = new Point($cs, $x1, $y2);

        return new self($cs, $p1, $p2, $p3, $p4, $p1);
    }

    /**
     * Returns the number of Points in this LineString.
     *
     * @return int
     */
    public function numPoints() : int
    {
        return $this->count();
    }

    /**
     * Returns the specified Point N in this LineString.
     *
     * @param int $n the point number, 1-based
     *
     * @throws NoSuchGeometryException if there is no Point at this index
     * @return Point
     */
    public function pointN(int $n) : Point
    {
        return $this->element($n);
    }

    /**
     * {@inheritdoc}
     */
    protected function validate() : void
    {
        if ($this->count() < 2) {
            throw new InvalidGeometryException('A LineString must be composed of at least 2 points.');
        }
    }
}
