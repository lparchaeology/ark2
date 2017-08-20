<?php

namespace ARK\Spatial\Engine;

use ARK\Spatial\Exception\GeometryEngineException;
use ARK\Spatial\Geometry\Geometry;
use ARK\Spatial\IO\EWKBReader;
use ARK\Spatial\IO\EWKBWriter;

/**
 * GeometryEngine implementation based on the GEOS PHP bindings.
 */
class GEOSEngine implements GeometryEngineInterface
{
    /**
     * @var \GEOSWKBReader
     */
    private $wkbReader;

    /**
     * @var \GEOSWKBWriter
     */
    private $wkbWriter;

    /**
     * @var \GEOSWKTReader
     */
    private $wktReader;

    /**
     * @var \GEOSWKTWriter
     */
    private $wktWriter;

    /**
     * @var \ARK\Spatial\IO\EWKBReader
     */
    private $ewkbReader;

    /**
     * @var \ARK\Spatial\IO\EWKBWriter
     */
    private $ewkbWriter;

    /**
     * Whether the GEOS version in use has support for binary read() and write() methods.
     *
     * These methods are available since GEOS 3.5.0.
     *
     * @var bool
     */
    private $hasBinaryReadWrite;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->wkbReader = new \GEOSWKBReader();
        $this->wkbWriter = new \GEOSWKBWriter();

        $this->wktReader = new \GEOSWKTReader();
        $this->wktWriter = new \GEOSWKTWriter();

        $this->ewkbReader = new EWKBReader();
        $this->ewkbWriter = new EWKBWriter();

        $this->hasBinaryReadWrite =
            method_exists($this->wkbReader, 'read') &&
            method_exists($this->wkbWriter, 'write');
    }

    /**
     * {@inheritdoc}
     */
    public function union(Geometry $a, Geometry $b) : Geometry
    {
        try {
            return $this->fromGEOS($this->toGEOS($a)->union($this->toGEOS($b)));
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function difference(Geometry $a, Geometry $b) : Geometry
    {
        try {
            return $this->fromGEOS($this->toGEOS($a)->difference($this->toGEOS($b)));
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function envelope(Geometry $g) : Geometry
    {
        try {
            return $this->fromGEOS($this->toGEOS($g)->envelope());
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function length(Geometry $g) : float
    {
        try {
            return $this->toGEOS($g)->length();
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function area(Geometry $g) : float
    {
        try {
            return $this->toGEOS($g)->area();
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function centroid(Geometry $g) : Geometry
    {
        try {
            return $this->fromGEOS($this->toGEOS($g)->centroid());
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function pointOnSurface(Geometry $g) : Geometry
    {
        try {
            return $this->fromGEOS($this->toGEOS($g)->pointOnSurface());
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function boundary(Geometry $g) : Geometry
    {
        try {
            return $this->fromGEOS($this->toGEOS($g)->boundary());
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isValid(Geometry $g) : bool
    {
        try {
            return $this->toGEOS($g)->checkValidity()['valid'];
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isClosed(Geometry $g) : bool
    {
        try {
            return $this->toGEOS($g)->isClosed();
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isSimple(Geometry $g) : bool
    {
        try {
            return $this->toGEOS($g)->isSimple();
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function equals(Geometry $a, Geometry $b) : bool
    {
        try {
            return $this->toGEOS($a)->equals($this->toGEOS($b));
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function disjoint(Geometry $a, Geometry $b) : bool
    {
        try {
            return $this->toGEOS($a)->disjoint($this->toGEOS($b));
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function intersects(Geometry $a, Geometry $b) : bool
    {
        try {
            return $this->toGEOS($a)->intersects($this->toGEOS($b));
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function touches(Geometry $a, Geometry $b) : bool
    {
        try {
            return $this->toGEOS($a)->touches($this->toGEOS($b));
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function crosses(Geometry $a, Geometry $b) : bool
    {
        try {
            return $this->toGEOS($a)->crosses($this->toGEOS($b));
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function within(Geometry $a, Geometry $b) : bool
    {
        try {
            return $this->toGEOS($a)->within($this->toGEOS($b));
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function contains(Geometry $a, Geometry $b) : bool
    {
        try {
            return $this->toGEOS($a)->contains($this->toGEOS($b));
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function overlaps(Geometry $a, Geometry $b) : bool
    {
        try {
            return $this->toGEOS($a)->overlaps($this->toGEOS($b));
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function relate(Geometry $a, Geometry $b, string $matrix) : bool
    {
        try {
            return $this->toGEOS($a)->relate($this->toGEOS($b), $matrix);
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function locateAlong(Geometry $g, float $mValue) : Geometry
    {
        throw GeometryEngineException::unimplementedMethod(__METHOD__);
    }

    /**
     * {@inheritdoc}
     */
    public function locateBetween(Geometry $g, float $mStart, float $mEnd) : Geometry
    {
        throw GeometryEngineException::unimplementedMethod(__METHOD__);
    }

    /**
     * {@inheritdoc}
     */
    public function distance(Geometry $a, Geometry $b) : float
    {
        try {
            return $this->toGEOS($a)->distance($this->toGEOS($b));
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buffer(Geometry $g, float $distance) : Geometry
    {
        try {
            return $this->fromGEOS($this->toGEOS($g)->buffer($distance));
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function convexHull(Geometry $g) : Geometry
    {
        try {
            return $this->fromGEOS($this->toGEOS($g)->convexHull());
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function intersection(Geometry $a, Geometry $b) : Geometry
    {
        try {
            return $this->fromGEOS($this->toGEOS($a)->intersection($this->toGEOS($b)));
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function symDifference(Geometry $a, Geometry $b) : Geometry
    {
        try {
            return $this->fromGEOS($this->toGEOS($a)->symDifference($this->toGEOS($b)));
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function snapToGrid(Geometry $g, float $size) : Geometry
    {
        throw GeometryEngineException::unimplementedMethod(__METHOD__);
    }

    /**
     * {@inheritdoc}
     */
    public function simplify(Geometry $g, float $tolerance) : Geometry
    {
        try {
            return $this->fromGEOS($this->toGEOS($g)->simplify($tolerance));
        } catch (\Exception $e) {
            throw GeometryEngineException::operationNotSupportedByEngine($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function maxDistance(Geometry $a, Geometry $b) : Geometry
    {
        throw GeometryEngineException::unimplementedMethod(__METHOD__);
    }

    /**
     * {@inheritdoc}
     */
    public function boundingPolygons(Geometry $g) : Geometry
    {
        throw GeometryEngineException::unimplementedMethod(__METHOD__);
    }

    /**
     * @param Geometry $geometry
     *
     * @return \GEOSGeometry
     */
    private function toGEOS(Geometry $geometry) : \GEOSGeometry
    {
        if ($geometry->isEmpty()) {
            $geosGeometry = $this->wktReader->read($geometry->asText());
            $geosGeometry->setSRID($geometry->SRID());

            return $geosGeometry;
        }

        if ($this->hasBinaryReadWrite) {
            return $this->wkbReader->read($this->ewkbWriter->write($geometry));
        }

        return $this->wkbReader->readHEX(bin2hex($this->ewkbWriter->write($geometry)));
    }

    /**
     * @param \GEOSGeometry $geometry
     *
     * @return Geometry
     */
    private function fromGEOS(\GEOSGeometry $geometry) : Geometry
    {
        if ($geometry->isEmpty()) {
            return Geometry::fromText($this->wktWriter->write($geometry), $geometry->getSRID());
        }

        if ($this->hasBinaryReadWrite) {
            return $this->ewkbReader->read($this->wkbWriter->write($geometry));
        }

        return $this->ewkbReader->read(hex2bin($this->wkbWriter->writeHEX($geometry)));
    }
}
