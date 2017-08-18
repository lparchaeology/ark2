<?php

namespace ARK\Spatial\Proxy;

use ARK\Spatial\Geometry\Geometry;

/**
 * Proxy trait for Surface.
 */
trait SurfaceProxyTrait
{
    /**
     * {@inheritdoc}
     */
    public function numPatches() : int
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->numPatches();
    }

    /**
     * {@inheritdoc}
     */
    public function patchN(int $n) : Geometry
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->patchN($n);
    }

    /**
     * {@inheritdoc}
     */
    public function patches() : iterable
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->patches();
    }
}
