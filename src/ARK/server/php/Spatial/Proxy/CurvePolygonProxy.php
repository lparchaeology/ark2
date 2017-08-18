<?php

namespace ARK\Spatial\Proxy;

use ARK\Spatial\Geometry\Curve;
use ARK\Spatial\Geometry\CurvePolygon;

/**
 * Proxy class for CurvePolygon.
 */
class CurvePolygonProxy extends CurvePolygon implements ProxyInterface
{
    use GeometryProxyTrait;

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
    public function getGeometry() : CurvePolygon
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromText(string $wkt, int $srid = 0) : CurvePolygonProxy
    {
        return new self($wkt, false, $srid);
    }

    /**
     * {@inheritdoc}
     */
    public static function fromBinary(string $wkb, int $srid = 0) : CurvePolygonProxy
    {
        return new self($wkb, true, $srid);
    }

    /**
     * {@inheritdoc}
     */
    public function exteriorRing() : Curve
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
    public function interiorRingN(int $n) : Curve
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
            ? CurvePolygon::fromBinary($this->proxyData, $this->proxySRID)
            : CurvePolygon::fromText($this->proxyData, $this->proxySRID);
    }
}
