<?php

namespace ARK\Spatial\Proxy;

use ARK\Spatial\Geometry\CircularString;

/**
 * Proxy class for CircularString.
 */
class CircularStringProxy extends CircularString implements ProxyInterface
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

    /**
     * {@inheritdoc}
     */
    public function getGeometry() : CircularString
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromText(string $wkt, int $srid = 0) : CircularStringProxy
    {
        return new self($wkt, false, $srid);
    }

    /**
     * {@inheritdoc}
     */
    public static function fromBinary(string $wkb, int $srid = 0) : CircularStringProxy
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
            ? CircularString::fromBinary($this->proxyData, $this->proxySRID)
            : CircularString::fromText($this->proxyData, $this->proxySRID);
    }
}
