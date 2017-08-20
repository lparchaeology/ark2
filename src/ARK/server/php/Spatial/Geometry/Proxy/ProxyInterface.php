<?php

namespace ARK\Spatial\Geometry\Proxy;

use ARK\Spatial\Geometry\Geometry;

/**
 * Interface implemented by geometry proxies.
 */
interface ProxyInterface
{
    /**
     * Returns whether the underlying Geometry is loaded.
     *
     * @return bool
     */
    public function isLoaded() : bool;

    /**
     * Loads and returns the underlying Geometry.
     *
     * @return Geometry
     */
    public function geometry() : Geometry;
}
