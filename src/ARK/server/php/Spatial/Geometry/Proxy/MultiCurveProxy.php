<?php

namespace ARK\Spatial\Geometry\Proxy;

use ARK\Spatial\MultiCurve;

/**
 * Proxy class for MultiCurve.
 */
class MultiCurveProxy extends MultiCurve implements ProxyInterface
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

    /**
     * {@inheritdoc}
     */
    public function getGeometry() : MultiCurve
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromText(string $wkt, int $srid = 0) : MultiCurveProxy
    {
        return new self($wkt, false, $srid);
    }

    /**
     * {@inheritdoc}
     */
    public static function fromBinary(string $wkb, int $srid = 0) : MultiCurveProxy
    {
        return new self($wkb, true, $srid);
    }

    /**
     * Loads the underlying geometry.
     *
     *
     * @throws GeometryIOException         if the proxy data is not valid
     * @throws CoordinateSystemException   if the resulting geometry contains mixed coordinate systems
     * @throws InvalidGeometryException    if the resulting geometry is not valid
     * @throws UnexpectedGeometryException if the resulting geometry is not an instance of the proxied class
     */
    private function load() : void
    {
        $this->proxyGeometry = $this->proxyIsBinary
            ? MultiCurve::fromBinary($this->proxyData, $this->proxySRID)
            : MultiCurve::fromText($this->proxyData, $this->proxySRID);
    }
}
