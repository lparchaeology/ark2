<?php

namespace ARK\Spatial\Geometry\Proxy;

use ARK\Spatial\Geometry\Point;

/**
 * Proxy trait for Curve.
 */
trait CurveProxyTrait
{
    /**
     * {@inheritdoc}
     */
    public function startPoint() : Point
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }
        return $this->proxyGeometry->startPoint();
    }

    /**
     * {@inheritdoc}
     */
    public function endPoint() : Point
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }
        return $this->proxyGeometry->endPoint();
    }

    /**
     * {@inheritdoc}
     */
    public function numPoints() : int
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }
        return $this->proxyGeometry->numPoints();
    }

    /**
     * {@inheritdoc}
     */
    public function pointN(int $n) : Point
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }
        return $this->proxyGeometry->pointN($n);
    }
}
