<?php

namespace ARK\Spatial\Geometry;

use ARK\Spatial\Spatial;

/**
 * {@inheritdoc}
 */
abstract class Surface extends Geometry implements SurfaceInterface
{
    /**
     * {@inheritdoc}
     */
    public function area() : float
    {
        return Spatial::geometry()->area($this);
    }

    /**
     * {@inheritdoc}
     */
    public function centroid() : Point
    {
        return Spatial::geometry()->centroid($this);
    }

    /**
     * {@inheritdoc}
     */
    public function pointOnSurface() : Point
    {
        return Spatial::geometry()->pointOnSurface($this);
    }
}
