<?php

namespace ARK\Spatial\Geometry;

use ARK\Spatial\Spatial;

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
        return Spatial::geometry()->isClosed($this);
    }

    /**
     * {@inheritdoc}
     */
    public function length() : float
    {
        return Spatial::geometry()->length($this);
    }
}
