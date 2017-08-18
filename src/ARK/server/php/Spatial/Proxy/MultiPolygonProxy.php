<?php

namespace ARK\Spatial\Proxy;

use ARK\Spatial\Exception\CoordinateSystemException;
use ARK\Spatial\Exception\GeometryIOException;
use ARK\Spatial\Exception\InvalidGeometryException;
use ARK\Spatial\Exception\UnexpectedGeometryException;
use ARK\Spatial\Geometry\MultiPolygon;

/**
 * Proxy class for MultiPolygon.
 */
class MultiPolygonProxy extends MultiPolygon implements ProxyInterface
{
    /**
     * The WKT or WKB data.
     *
     * @var string
     */
    private $proxyData;

    /**
     * `true` if WKB, `false` if WKT.
     *
     * @var bool
     */
    private $proxyIsBinary;

    /**
     * The SRID of the underlying geometry.
     *
     * @var int
     */
    private $proxySRID;

    /**
     * The underlying geometry, or NULL if not yet loaded.
     *
     * @var MultiPolygon|null
     */
    private $proxyGeometry;

    /**
     * Class constructor.
     *
     * @param string $data     the WKT or WKB data
     * @param bool   $isBinary whether the data is binary (true) or text (false)
     * @param int    $srid     the SRID of the geometry
     */
    public function __construct(string$data,bool $isBinary,int $srid = 0)
    {
        $this->proxyData =  $data;
        $this->proxyIsBinary =  $isBinary;
        $this->proxySRID =  $srid;
    }

    /**
     * {@inheritdoc}
     */
    public function isLoaded()bool
    {
        return $this->proxyGeometry !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function getGeometry():Geometry
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromText(string$wkt,int $srid = 0):MultiPolygonProxy
    {
        return new self($wkt, false, $srid);
    }

    /**
     * {@inheritdoc}
     */
    public static function fromBinary(string$wkb,int $srid = 0):MultiPolygonProxy
    {
        return new self($wkb, true, $srid);
    }

    /**
     * {@inheritdoc}
     */
    public function SRID():int
    {
        return $this->proxySRID;
    }

    /**
     * {@inheritdoc}
     */
    public function asText():string
    {
        if (!$this->proxyIsBinary) {
            return $this->proxyData;
        }

        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->asText();
    }

    /**
     * {@inheritdoc}
     */
    public function asBinary():string
    {
        if ($this->proxyIsBinary) {
            return $this->proxyData;
        }

        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->asBinary();
    }

    /**
     * {@inheritdoc}
     */
    public function dimension():int
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->dimension();
    }

    /**
     * {@inheritdoc}
     */
    public function numGeometries():int
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->numGeometries();
    }

    /**
     * {@inheritdoc}
     */
    public function geometryN(int $n):Geometry
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->geometryN($n);
    }

    /**
     * {@inheritdoc}
     */
    public function geometries():iterable
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->geometries();
    }

    /**
     * {@inheritdoc}
     */
    public function toArray():array
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function count():int
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->count();
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator():\ArrayIterator
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->getIterator();
    }

    /**
     * {@inheritdoc}
     */
    public function coordinateDimension():int
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->coordinateDimension();
    }

    /**
     * {@inheritdoc}
     */
    public function spatialDimension():int
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->spatialDimension();
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty():bool
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->isEmpty();
    }

    /**
     * {@inheritdoc}
     */
    public function is3D():bool
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->is3D();
    }

    /**
     * {@inheritdoc}
     */
    public function isMeasured():bool
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->isMeasured();
    }

    /**
     * {@inheritdoc}
     */
    public function coordinateSystem():CoordinateSystem
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->coordinateSystem();
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
            ? MultiPolygon::fromBinary($this->proxyData, $this->proxySRID)
            : MultiPolygon::fromText($this->proxyData, $this->proxySRID);
    }
}
