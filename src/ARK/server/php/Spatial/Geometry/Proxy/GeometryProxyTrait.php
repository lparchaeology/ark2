<?php

namespace ARK\Spatial\Geometry\Proxy;

use ARK\Spatial\Geometry\CoordinateSystem;

/**
 * Proxy trait.
 */
trait GeometryProxyTrait
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
     * @var Geometry|null
     */
    private $proxyGeometry;

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
    public function geometry() : Geometry
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }
        return $this->proxyGeometry;
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
     * {@inheritdoc}
     */
    public function elementType() : string
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }
        return $this->proxyGeometry->elementType();
    }

    /**
     * {@inheritdoc}
     */
    public function elementClass() : string
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }
        return $this->proxyGeometry->elementClass();
    }

    /**
     * {@inheritdoc}
     */
    public function elements() : iterable
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }
        return $this->proxyGeometry->elements();
    }

    /**
     * {@inheritdoc}
     */
    public function element(int $n) : Geometry
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }
        return $this->proxyGeometry->element($n);
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
    public static function fromText(string $wkt, int $srid = 0) : GeometryProxy
    {
        return new self($wkt, false, $srid);
    }

    /**
     * {@inheritdoc}
     */
    public static function fromBinary(string $wkb, int $srid = 0) : GeometryProxy
    {
        return new self($wkb, true, $srid);
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
    public function dimension() : int
    {
        if ($this->proxyGeometry === null) {
            $this->load();
        }

        return $this->proxyGeometry->dimension();
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
     * Loads the underlying geometry.
     *
     *
     * @throws GeometryIOException         if the proxy data is not valid
     * @throws CoordinateSystemException   if the resulting geometry contains mixed coordinate systems
     * @throws InvalidGeometryException    if the resulting geometry is not valid
     * @throws UnexpectedGeometryException if the resulting geometry is not an instance of the proxied class
     */
    protected function load() : void
    {
        $this->proxyGeometry = $this->proxyIsBinary
            ? self::fromBinary($this->proxyData, $this->proxySRID)
            : self::fromText($this->proxyData, $this->proxySRID);
    }
}
