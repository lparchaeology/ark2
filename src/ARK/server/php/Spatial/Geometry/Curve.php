<?php

namespace ARK\Spatial;

use ARK\Spatial\Engine\GeometryEngineRegistry;

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
        return GeometryEngineRegistry::get()->length($this);
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
        return GeometryEngineRegistry::get()->isClosed($this);
    }

    /**
     * {@inheritdoc}
     */
    public function isRing() : bool
    {
        return $this->isClosed() && $this->isSimple();
    }
}
