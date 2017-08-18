<?php

namespace ARK\Spatial\Proxy;

use ARK\Spatial\Exception\CoordinateSystemException;
use ARK\Spatial\Exception\GeometryIOException;
use ARK\Spatial\Exception\InvalidGeometryException;
use ARK\Spatial\Exception\UnexpectedGeometryException;
use ARK\Spatial\Geometry\CircularString;
use ARK\Spatial\Geometry\CoordinateSystem;
use ARK\Spatial\Geometry\Point;

/**
 * Proxy class for CircularString.
 */
class CircularStringProxy extends CircularString implements ProxyInterface
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
     * @var CircularString|null
     */
    private $proxyGeometry;

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
    public function isLoaded() : bool
    {
        return $this->proxyGeometry !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function getGeometry() : Geometry
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
     * {@inheritdoc}
     */
    public function SRID() : int
    {
        return $this->proxySRID;
    }

    /**
     * {@inheritdoc}
     */
    public function asText() : string
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
    public function asBinary() : string
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
    public function startPoint() : Point
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->startPoint();
    }

    /**
     * {@inheritdoc}
     */
    public function endPoint() : Point
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->endPoint();
    }

    /**
     * {@inheritdoc}
     */
    public function numPoints() : int
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->numPoints();
    }

    /**
     * {@inheritdoc}
     */
    public function pointN(int $n) : Point
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->pointN($n);
    }

    /**
     * {@inheritdoc}
     */
    public function points() : iterable
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->points();
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function count() : int
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->count();
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator() : \ArrayIterator
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->getIterator();
    }

    /**
     * {@inheritdoc}
     */
    public function coordinateDimension() : int
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->coordinateDimension();
    }

    /**
     * {@inheritdoc}
     */
    public function spatialDimension() : int
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->spatialDimension();
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty() : bool
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->isEmpty();
    }

    /**
     * {@inheritdoc}
     */
    public function is3D() : bool
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->is3D();
    }

    /**
     * {@inheritdoc}
     */
    public function isMeasured() : bool
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->isMeasured();
    }

    /**
     * {@inheritdoc}
     */
    public function coordinateSystem() : CoordinateSystem
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
            ? CircularString::fromBinary($this->proxyData, $this->proxySRID)
            : CircularString::fromText($this->proxyData, $this->proxySRID);
    }
}
