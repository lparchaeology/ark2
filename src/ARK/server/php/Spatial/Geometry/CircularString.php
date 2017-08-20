<?php

namespace ARK\Spatial;

use ARK\Spatial\Exception\CoordinateSystemException;
use ARK\Spatial\Exception\InvalidGeometryException;

/**
 * A CircularString is a Curve made of zero or more connected circular arc segments.
 *
 * A circular arc segment is a curved segment defined by three points in a two-dimensional plane;
 * the first point cannot be the same as the third point.
 */
class CircularString extends Curve implements LineStringInterface
{
    /**
     * @param CoordinateSystem $cs
     * @param Point            ...$points
     *
     * @throws InvalidGeometryException  if the number of points is invalid
     * @throws CoordinateSystemException if different coordinate systems are used
     * @return CircularString
     */
    public function __construct(CoordinateSystem $cs, Point ...$points)
    {
        $this->init(Geometry::CIRCULARSTRING, $cs, $points ?? []);
    }

    /**
     * Creates a non-empty CircularString composed of the given points.
     *
     * @param Point $point1    the first point
     * @param Point ...$pointN The subsequent points.
     *
     * @throws InvalidGeometryException  if the number of points is invalid
     * @throws CoordinateSystemException if the points use different coordinate systems
     * @return CircularString
     */
    public static function of(Point $point1, Point ...$pointN) : CircularString
    {
        return new self($point1->coordinateSystem(), $point1, ...$pointN);
    }

    /**
     * {@inheritdoc}
     */
    public function numPoints() : int
    {
        return $this->count();
    }

    /**
     * {@inheritdoc}
     */
    public function pointN(int $n) : Point
    {
        return $this->element($n);
    }

    /**
     * Validate the class members.
     */
    protected function validate() : void
    {
        $points = $this->count();
        if ($points < 3) {
            throw new InvalidGeometryException('A CircularString must be made of at least 3 points.');
        }
        if ($points % 2 === 0) {
            throw new InvalidGeometryException('A CircularString must have an odd number of points.');
        }
    }
}
