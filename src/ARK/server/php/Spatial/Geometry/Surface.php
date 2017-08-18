<?php

namespace Brick\Geo;

use Brick\Geo\Engine\GeometryEngineRegistry;
use Brick\Geo\Exception\GeometryEngineException;

/**
 * A Surface is a 2-dimensional geometric object.
 *
 * A simple Surface may consists of a single "patch" that is associated with one "exterior boundary" and 0 or more
 * "interior" boundaries. A single such Surface patch in 3-dimensional space is isometric to planar Surfaces, by a
 * simple affine rotation matrix that rotates the patch onto the plane z = 0. If the patch is not vertical,
 * the projection onto the same plane is an isomorphism, and can be represented as a linear transformation,
 * i.e. an affine.
 *
 * Polyhedral Surfaces are formed by "stitching" together such simple Surfaces patches along their common
 * boundaries. Such polyhedral Surfaces in a 3-dimensional space may not be planar as a whole, depending on the
 * orientation of their planar normals. If all the patches are in alignment (their normals are parallel),
 * then the whole stitched polyhedral surface is co-planar and can be represented as a single patch if it is connected.
 *
 * The boundary of a simple Surface is the set of closed Curves corresponding to its "exterior" and "interior"
 * boundaries.
 */
abstract class Surface extends Geometry
{
    /**
     * @noproxy
     *
     * {@inheritdoc}
     *
     * A Surface is a 2-dimensional geometric object.
     */
    public function dimension()
    {
        return 2;
    }

    /**
     * Returns the area of this Surface, as measured in the spatial reference system of this Surface.
     *
     * @noproxy
     *
     * @return float
     *
     * @throws GeometryEngineException If the operation is not supported by the geometry engine.
     */
    public function area()
    {
        return GeometryEngineRegistry::get()->area($this);
    }

    /**
     * Returns the mathematical centroid for this Surface as a Point.
     *
     * The result is not guaranteed to be on this Surface.
     *
     * @noproxy
     *
     * @return Point
     *
     * @throws GeometryEngineException If the operation is not supported by the geometry engine.
     */
    public function centroid()
    {
        return GeometryEngineRegistry::get()->centroid($this);
    }

    /**
     * Returns a Point guaranteed to be on this Surface.
     *
     * @noproxy
     *
     * @return Point
     *
     * @throws GeometryEngineException If the operation is not supported by the geometry engine.
     */
    public function pointOnSurface()
    {
        return GeometryEngineRegistry::get()->pointOnSurface($this);
    }
}
