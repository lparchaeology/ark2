<?php

namespace ARK\Spatial\Geometry\Proxy;

use ARK\Spatial\Geometry\Geometry;

/**
 * Proxy trait for GeometryCollection.
 */
trait GeometryCollectionProxyTrait
{
    /**
     * {@inheritdoc}
     */
    public function numGeometries() : int
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->numGeometries();
    }

    /**
     * {@inheritdoc}
     */
    public function geometryN(int $n) : Geometry
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->geometryN($n);
    }
}
