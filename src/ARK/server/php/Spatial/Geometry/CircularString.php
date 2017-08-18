<?php

namespace ARK\Spatial;

use ARK\Spatial\Exception\CoordinateSystemException;
use ARK\Spatial\Exception\EmptyGeometryException;
use ARK\Spatial\Exception\InvalidGeometryException;
use ARK\Spatial\Exception\NoSuchGeometryException;

/**
 * A CircularString is a Curve made of zero or more connected circular arc segments.
 *
 * A circular arc segment is a curved segment defined by three points in a two-dimensional plane;
 * the first point cannot be the same as the third point.
 */
class CircularString extends Curve
{
    /**
     * The Points that compose this CircularString.
     *
     * An empty CircularString contains no points.
     *
     * @var Point[]
     */
    protected $points = [];

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
        parent::__construct($cs, !$points);

        if (!$points) {
            return;
        }

        CoordinateSystem::check($this, ...$points);

        $numPoints = count($points);

        if ($numPoints < 3) {
            throw new InvalidGeometryException('A CircularString must be made of at least 3 points.');
        }

        if ($numPoints % 2 === 0) {
            throw new InvalidGeometryException('A CircularString must have an odd number of points.');
        }

        $this->points = $points;
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
    public function startPoint() : Point
    {
        if ($this->isEmpty) {
            throw new EmptyGeometryException('The CircularString is empty and has no start point.');
        }

        return $this->points[0];
    }

    /**
     * {@inheritdoc}
     */
    public function endPoint() : Point
    {
        if ($this->isEmpty) {
            throw new EmptyGeometryException('The CircularString is empty and has no end point.');
        }

        return end($this->points);
    }

    /**
     * Returns the number of Points in this CircularString.
     *
     * @return int
     */
    public function numPoints() : int
    {
        return count($this->points);
    }

    /**
     * Returns the specified Point N in this CircularString.
     *
     * @param int $n the point number, 1-based
     *
     * @throws NoSuchGeometryException if there is no Point at this index
     * @return Point
     */
    public function pointN(int $n) : Point
    {
        $n = (int) $n;

        if (!isset($this->points[$n - 1])) {
            throw new NoSuchGeometryException('There is no Point in this CircularString at index '.$n);
        }

        return $this->points[$n - 1];
    }

    /**
     * Returns the points that compose this CircularString.
     *
     * @return Point[]
     */
    public function points() : iterable
    {
        return $this->points;
    }

    /**
     * @noproxy
     *
     * {@inheritdoc}
     */
    public function geometryType() : string
    {
        return 'CircularString';
    }

    /**
     * @noproxy
     *
     * {@inheritdoc}
     */
    public function geometryTypeBinary() : int
    {
        return Geometry::CIRCULARSTRING;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        $result = [];

        foreach ($this->points as $point) {
            $result[] = $point->toArray();
        }

        return $result;
    }

    /**
     * Returns the number of points in this CircularString.
     *
     * Required by interface Countable.
     *
     * {@inheritdoc}
     */
    public function count() : int
    {
        return count($this->points);
    }

    /**
     * Returns an iterator for the points in this CircularString.
     *
     * Required by interface IteratorAggregate.
     *
     * {@inheritdoc}
     */
    public function getIterator() : \ArrayIterator
    {
        return new \ArrayIterator($this->points);
    }
}
