<?php

namespace ARK\Spatial;

use ARK\Spatial\Engine\GeometryEngineRegistry;
use ARK\Spatial\Exception\EmptyGeometryException;
use ARK\Spatial\Exception\GeometryEngineException;

/**
 * A Curve is a 1-dimensional geometric object usually stored as a sequence of Points.
 *
 * The subtype of Curve specifies the form of the interpolation between Points.
 */
abstract class Curve extends Geometry
{
    /**
     * @noproxy
     *
     * {@inheritdoc}
     *
     * A Curve is a 1-dimensional geometric object.
     */
    public function dimension() : int
    {
        return 1;
    }

    /**
     * Returns the length of this Curve in its associated spatial reference.
     *
     * @noproxy
     *
     * @throws GeometryEngineException if the operation is not supported by the geometry engine
     * @return float
     */
    public function length() : float
    {
        return GeometryEngineRegistry::get()->length($this);
    }

    /**
     * Returns the start Point of this Curve.
     *
     * @throws EmptyGeometryException if the curve is empty
     * @return Point
     */
    abstract public function startPoint() : Point;

    /**
     * Returns the end Point of this Curve.
     *
     * @throws EmptyGeometryException if the curve is empty
     * @return Point
     */
    abstract public function endPoint() : Point;

    /**
     * Returns whether this Curve is closed.
     *
     * The curve is closed if `startPoint()` == `endPoint()`.
     *
     * @noproxy
     *
     * @throws GeometryEngineException if the operation is not supported by the geometry engine
     * @return bool
     */
    public function isClosed() : bool
    {
        return GeometryEngineRegistry::get()->isClosed($this);
    }

    /**
     * Returns whether this Curve is a ring.
     *
     * The curve is a ring if it is both closed and simple.
     *
     * The curve is closed if its start point is equal to its end point.
     * The curve is simple if it does not pass through the same point more than once.
     *
     * @noproxy
     *
     * @throws GeometryEngineException if the operation is not supported by the geometry engine
     * @return bool
     */
    public function isRing() : bool
    {
        return $this->isClosed() && $this->isSimple();
    }
}
