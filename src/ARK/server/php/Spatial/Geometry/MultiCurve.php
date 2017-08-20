<?php

namespace ARK\Spatial\Geometry;

use ARK\Spatial\Engine\GeometryEngineRegistry;

/**
 * {@inheritdoc}
 */
abstract class MultiCurve extends GeometryCollection implements MultiCurveInterface
{
    /**
     * {@inheritdoc}
     */
    public function isClosed() : bool
    {
        return GeometryEngineRegistry::get()->isClosed($this);
    }

    /**
     * {@inheritdoc}
     */
    public function length() : float
    {
        return GeometryEngineRegistry::get()->length($this);
    }
}
