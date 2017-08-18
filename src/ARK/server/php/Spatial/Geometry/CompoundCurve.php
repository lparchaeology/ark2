<?php

namespace ARK\Spatial;

use ARK\Spatial\Exception\CoordinateSystemException;
use ARK\Spatial\Exception\EmptyGeometryException;
use ARK\Spatial\Exception\InvalidGeometryException;
use ARK\Spatial\Exception\NoSuchGeometryException;

/**
 * A CompoundCurve is a collection of zero or more continuous CircularString or LineString instances.
 */
class CompoundCurve extends Curve
{
    /**
     * The Curves that compose this CompoundCurve.
     *
     * This array can be empty.
     *
     * @var Curve[]
     */
    protected $curves = [];

    /**
     * Class constructor.
     *
     * The coordinate system of each of the curves must match the one of the CompoundCurve.
     *
     * @param CoordinateSystem $cs        the coordinate system of the CompoundCurve
     * @param Curve            ...$curves The curves that compose the CompoundCurve.
     *
     * @throws EmptyGeometryException    if any of the input curves is empty
     * @throws InvalidGeometryException  if the compound curve is not continuous
     * @throws CoordinateSystemException if different coordinate systems are used
     */
    public function __construct(CoordinateSystem $cs, Curve ...$curves)
    {
        parent::__construct($cs, !$curves);

        if (!$curves) {
            return;
        }

        CoordinateSystem::check($this, ...$curves);

        /** @var Curve|null $previousCurve */
        $previousCurve = null;

        foreach ($curves as $curve) {
            if ($previousCurve) {
                $endPoint = $previousCurve->endPoint();
                $startPoint = $curve->startPoint();

                if ($endPoint !== $startPoint) { // on purpose by-value comparison!
                    throw new InvalidGeometryException('Incontinuous compound curve.');
                }
            }

            $previousCurve = $curve;
        }

        $this->curves = $curves;
    }

    /**
     * Creates a non-empty CompoundCurve composed of the given curves.
     *
     * @param Curve $curve1    the first curve
     * @param Curve ...$curveN The subsequent curves, if any.
     *
     * @throws EmptyGeometryException    if any of the input curves is empty
     * @throws InvalidGeometryException  if the compound curve is not continuous
     * @throws CoordinateSystemException if the curves use different coordinate systems
     * @return CompoundCurve
     */
    public static function of(Curve $curve1, Curve ...$curveN) : CompoundCurve
    {
        return new self($curve1->coordinateSystem(), $curve1, ...$curveN);
    }

    /**
     * {@inheritdoc}
     */
    public function startPoint() : Point
    {
        if ($this->isEmpty) {
            throw new EmptyGeometryException('The CompoundCurve is empty and has no start point.');
        }

        return $this->curves[0]->startPoint();
    }

    /**
     * {@inheritdoc}
     */
    public function endPoint() : Point
    {
        if ($this->isEmpty) {
            throw new EmptyGeometryException('The CompoundCurve is empty and has no end point.');
        }

        $count = count($this->curves);

        return $this->curves[$count - 1]->endPoint();
    }

    /**
     * Returns the number of Curves in this CompoundCurve.
     *
     * @return int
     */
    public function numCurves() : int
    {
        return count($this->curves);
    }

    /**
     * Returns the specified Curve N in this CompoundCurve.
     *
     * @param int $n the curve number, 1-based
     *
     * @throws NoSuchGeometryException if there is no Curve at this index
     * @return Curve
     */
    public function curveN($n) : int
    {
        $n = (int) $n;

        if (!isset($this->curves[$n - 1])) {
            throw new NoSuchGeometryException('There is no Curve in this CompoundCurve at index '.$n);
        }

        return $this->curves[$n - 1];
    }

    /**
     * Returns the curves that compose this CompoundCurve.
     *
     * @return Curve[]
     */
    public function curves() : iterable
    {
        return $this->curves;
    }

    /**
     * @noproxy
     *
     * {@inheritdoc}
     */
    public function geometryType() : string
    {
        return 'CompoundCurve';
    }

    /**
     * @noproxy
     *
     * {@inheritdoc}
     */
    public function geometryTypeBinary() : int
    {
        return Geometry::COMPOUNDCURVE;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        $result = [];

        foreach ($this->curves as $curve) {
            $result[] = $curve->toArray();
        }

        return $result;
    }

    /**
     * Returns the number of curves in this CompoundCurve.
     *
     * Required by interface Countable.
     *
     * {@inheritdoc}
     */
    public function count() : int
    {
        return count($this->curves);
    }

    /**
     * Returns an iterator for the curves in this CompoundCurve.
     *
     * Required by interface IteratorAggregate.
     *
     * {@inheritdoc}
     */
    public function getIterator() : \ArrayIterator
    {
        return new \ArrayIterator($this->curves);
    }
}
