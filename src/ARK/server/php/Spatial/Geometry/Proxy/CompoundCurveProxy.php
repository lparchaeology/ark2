<?php

namespace ARK\Spatial\Geometry\Proxy;

use ARK\Spatial\Geometry\CompoundCurve;

/**
 * Proxy class for CompoundCurve.
 */
class CompoundCurveProxy extends CompoundCurve implements ProxyInterface
{
    use GeometryProxyTrait;
    use CurveProxyTrait;

    /**
     * Class constructor.
     *
     * @param string $data     the WKT or WKB data
     * @param bool   $isBinary whether the data is binary (true) or text (false)
     * @param int    $srid     the SRID of the geometry
     */
    public function __construct(string $data, bool $isBinary, int $srid = 0)
    {
        $this->proxyData = $data;
        $this->proxyIsBinary = $isBinary;
        $this->proxySRID = $srid;
    }
}
