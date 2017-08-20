<?php

namespace ARK\Spatial\Geometry;

use ARK\Spatial\Engine\GeometryEngineRegistry;

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
        return GeometryEngineRegistry::get()->area($this);
    }

    /**
     * {@inheritdoc}
     */
    public function centroid() : Point
    {
        return GeometryEngineRegistry::get()->centroid($this);
    }

    /**
     * {@inheritdoc}
     */
    public function pointOnSurface() : Point
    {
        return GeometryEngineRegistry::get()->pointOnSurface($this);
    }
}
