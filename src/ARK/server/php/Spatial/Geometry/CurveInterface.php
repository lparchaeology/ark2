<?php

namespace ARK\Spatial\Geometry;

/**
 * A Curve is a 1-dimensional geometric object usually stored as a sequence of Points.
 *
 * The subtype of Curve specifies the form of the interpolation between Points.
 */
interface CurveInterface
{
    /**
     * Returns the length of this Curve in its associated spatial reference.
     *
     * @throws GeometryEngineException if the operation is not supported by the geometry engine
     * @return float
     */
    public function length() : float;

    /**
     * Returns the start Point of this Curve.
     *
     * @throws EmptyGeometryException if the curve is empty
     * @return Point
     */
    public function startPoint() : Point;

    /**
     * Returns the end Point of this Curve.
     *
     * @throws EmptyGeometryException if the curve is empty
     * @return Point
     */
    public function endPoint() : Point;

    /**
     * Returns whether this Curve is closed.
     *
     * The curve is closed if `startPoint()` == `endPoint()`.
     *
     * @throws GeometryEngineException if the operation is not supported by the geometry engine
     * @return bool
     */
    public function isClosed() : bool;

    /**
     * Returns whether this Curve is a ring.
     *
     * The curve is a ring if it is both closed and simple.
     *
     * The curve is closed if its start point is equal to its end point.
     * The curve is simple if it does not pass through the same point more than once.
     *
     * @throws GeometryEngineException if the operation is not supported by the geometry engine
     * @return bool
     */
    public function isRing() : bool;
}
