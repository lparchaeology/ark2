<?php

namespace ARK\Spatial\Geometry;

use ARK\Spatial\Spatial;
use ARK\Spatial\Exception\EmptyGeometryException;

/**
 * {@inheritdoc}
 */
abstract class Curve extends Geometry implements CurveInterface
{
    /**
     * {@inheritdoc}
     */
    public function length() : float
    {
        return Spatial::geometry()->length($this);
    }

    /**
     * {@inheritdoc}
     */
    public function startPoint() : Point
    {
        if ($this->isEmpty) {
            throw new EmptyGeometryException('The LineString is empty and has no start point.');
        }
        return $this->element(0);
    }

    /**
     * {@inheritdoc}
     */
    public function endPoint() : Point
    {
        if ($this->isEmpty) {
            throw new EmptyGeometryException('The LineString is empty and has no end point.');
        }
        return end($this->elements);
    }

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
    public function isRing() : bool
    {
        return $this->isClosed() && $this->isSimple();
    }
}
