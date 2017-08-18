<?php

namespace ARK\Spatial\Proxy;

use ARK\Spatial\Geometry\LineString;

/**
 * Proxy trait for Polygon.
 */
trait PolygonProxyTrait
{
    /**
     * {@inheritdoc}
     */
    public function exteriorRing() : LineString
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }
        return $this->proxyGeometry->exteriorRing();
    }

    /**
     * {@inheritdoc}
     */
    public function numInteriorRings() : int
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }
        return $this->proxyGeometry->numInteriorRings();
    }

    /**
     * {@inheritdoc}
     */
    public function interiorRingN(int $n) : LineString
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }
        return $this->proxyGeometry->interiorRingN($n);
    }

    /**
     * {@inheritdoc}
     */
    public function interiorRings() : iterable
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }
        return $this->proxyGeometry->interiorRings();
    }
}
