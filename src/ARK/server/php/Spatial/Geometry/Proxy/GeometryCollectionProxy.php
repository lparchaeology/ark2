<?php

namespace ARK\Spatial\Geometry\Proxy;

use ARK\Spatial\Geometry\GeometryCollection;

/**
 * Proxy class for GeometryCollection.
 */
class GeometryCollectionProxy extends GeometryCollection implements ProxyInterface
{
    use GeometryProxyTrait;
    use GeometryCollectionProxyTrait;

    /**
     * Class constructor.
     *
     * @param string $data     the WKT or WKB data
     * @param bool   $isBinary whether the data is binary (true) or text (false)
     * @param int    $srid     the SRID of the geometry
     */
    public function __construct(string $data, bool $isBinary, int $srid = 0)
    {
        $this->proxyData = (string) $data;
        $this->proxyIsBinary = (bool) $isBinary;
        $this->proxySRID = (int) $srid;
    }
}
