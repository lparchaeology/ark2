<?php

namespace Brick\Geo;

use Brick\Geo\Exception\CoordinateSystemException;
use Brick\Geo\Exception\EmptyGeometryException;
use Brick\Geo\Exception\InvalidGeometryException;
use Brick\Geo\Exception\NoSuchGeometryException;

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
     * @param CoordinateSystem $cs        The coordinate system of the CompoundCurve.
     * @param Curve            ...$curves The curves that compose the CompoundCurve.
     *
     * @throws EmptyGeometryException    If any of the input curves is empty.
     * @throws InvalidGeometryException  If the compound curve is not continuous.
     * @throws CoordinateSystemException If different coordinate systems are used.
     */
    public function __construct(CoordinateSystem $cs, Curve ...$curves)
    {
        parent::__construct($cs, ! $curves);

        if (! $curves) {
            return;
        }

        CoordinateSystem::check($this, ...$curves);

        /** @var Curve|null $previousCurve */
        $previousCurve = null;

        foreach ($curves as $curve) {
            if ($previousCurve) {
                $endPoint = $previousCurve->endPoint();
                $startPoint = $curve->startPoint();

                if ($endPoint != $startPoint) { // on purpose by-value comparison!
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
     * @param Curve    $curve1 The first curve.
     * @param Curve ...$curveN The subsequent curves, if any.
     *
     * @return CompoundCurve
     *
     * @throws EmptyGeometryException    If any of the input curves is empty.
     * @throws InvalidGeometryException  If the compound curve is not continuous.
     * @throws CoordinateSystemException If the curves use different coordinate systems.
     */
    public static function of(Curve $curve1, Curve ...$curveN)
    {
        return new CompoundCurve($curve1->coordinateSystem(), $curve1, ...$curveN);
    }

    /**
     * {@inheritdoc}
     */
    public function startPoint()
    {
        if ($this->isEmpty) {
            throw new EmptyGeometryException('The CompoundCurve is empty and has no start point.');
        }

        return $this->curves[0]->startPoint();
    }

    /**
     * {@inheritdoc}
     */
    public function endPoint()
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
     * @return integer
     */
    public function numCurves()
    {
        return count($this->curves);
    }

    /**
     * Returns the specified Curve N in this CompoundCurve.
     *
     * @param integer $n The curve number, 1-based.
     *
     * @return Curve
     *
     * @throws NoSuchGeometryException If there is no Curve at this index.
     */
    public function curveN($n)
    {
        $n = (int) $n;

        if (! isset($this->curves[$n - 1])) {
            throw new NoSuchGeometryException('There is no Curve in this CompoundCurve at index ' . $n);
        }

        return $this->curves[$n - 1];
    }

    /**
     * Returns the curves that compose this CompoundCurve.
     *
     * @return Curve[]
     */
    public function curves()
    {
        return $this->curves;
    }

    /**
     * @noproxy
     *
     * {@inheritdoc}
     */
    public function geometryType()
    {
        return 'CompoundCurve';
    }

    /**
     * @noproxy
     *
     * {@inheritdoc}
     */
    public function geometryTypeBinary()
    {
        return Geometry::COMPOUNDCURVE;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
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
    public function count()
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
    public function getIterator()
    {
        return new \ArrayIterator($this->curves);
    }
}
