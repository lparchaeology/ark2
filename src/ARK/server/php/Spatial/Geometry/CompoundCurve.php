<?php

namespace ARK\Spatial\Geometry;

use ARK\Spatial\Exception\CoordinateSystemException;
use ARK\Spatial\Exception\EmptyGeometryException;
use ARK\Spatial\Exception\InvalidGeometryException;

/**
 * A CompoundCurve is a collection of zero or more continuous CircularString or LineString instances.
 */
class CompoundCurve extends Curve
{
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
        $this->init(Geometry::COMPOUNDCURVE, $cs, $curves ?? []);
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
     * Validate the class members.
     */
    protected function validate() : void
    {
        $previousCurve = null;
        foreach ($this->elements() as $curve) {
            if ($previousCurve) {
                $endPoint = $previousCurve->endPoint();
                $startPoint = $curve->startPoint();
                if ($endPoint !== $startPoint) { // on purpose by-value comparison!
                    throw new InvalidGeometryException('Incontinuous compound curve.');
                }
            }
            $previousCurve = $curve;
        }
    }
}
