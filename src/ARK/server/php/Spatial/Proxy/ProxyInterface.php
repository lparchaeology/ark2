<?php

namespace ARK\Spatial\Proxy;

use ARK\Spatial\Geometry;

/**
 * Interface implemented by geometry proxies.
 */
interface ProxyInterface
{
    /**
     * Returns whether the underlying Geometry is loaded.
     *
     * @return boolean
     */
    public function isLoaded();

    /**
     * Loads and returns the underlying Geometry.
     *
     * @return Geometry
     */
    public function getGeometry();
}
