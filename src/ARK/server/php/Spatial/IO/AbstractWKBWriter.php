<?php

namespace ARK\Spatial\IO;

use ARK\Spatial\Exception\GeometryIOException;
use ARK\Spatial\Geometry\CircularString;
use ARK\Spatial\Geometry\CompoundCurve;
use ARK\Spatial\Geometry\Curve;
use ARK\Spatial\Geometry\CurvePolygon;
use ARK\Spatial\Geometry\Geometry;
use ARK\Spatial\Geometry\GeometryCollection;
use ARK\Spatial\Geometry\LineString;
use ARK\Spatial\Geometry\Point;
use ARK\Spatial\Geometry\Polygon;
use ARK\Spatial\Geometry\PolyhedralSurface;

/**
 * Base class for WKBWriter and EWKBWriter.
 */
abstract class AbstractWKBWriter
{
    /**
     * The output byte order, BIG_ENDIAN or LITTLE_ENDIAN.
     *
     * @var int
     */
    private $byteOrder;

    /**
     * @var int
     */
    private $machineByteOrder;

    /**
     * @throws GeometryIOException
     */
    public function __construct()
    {
        $this->byteOrder = $this->machineByteOrder = WKBTools::getMachineByteOrder();
    }

    /**
     * @param int $byteOrder the byte order, one of the BIG_ENDIAN or LITTLE_ENDIAN constants
     *
     *
     * @throws \InvalidArgumentException if the byte order is invalid
     */
    public function setByteOrder(int $byteOrder) : void
    {
        WKBTools::checkByteOrder($byteOrder);
        $this->byteOrder = $byteOrder;
    }

    /**
     * @param Geometry $geometry the geometry to export as WKB
     *
     * @throws GeometryIOException if the given geometry cannot be exported as WKB
     * @return string              the WKB representation of the given geometry
     */
    public function write(Geometry $geometry) : string
    {
        return $this->doWrite($geometry, true);
    }

    /**
     * @param Geometry $geometry the geometry export as WKB write
     * @param bool     $outer    false if the geometry is nested in another geometry, true otherwise
     *
     * @throws GeometryIOException if the given geometry cannot be exported as WKT
     * @return string              the WKB representation of the given geometry
     */
    protected function doWrite(Geometry $geometry, bool $outer) : string
    {
        if ($geometry instanceof Point) {
            return $this->writePoint($geometry, $outer);
        }

        if ($geometry instanceof LineString) {
            return $this->writeCurve($geometry, $outer);
        }

        if ($geometry instanceof CircularString) {
            return $this->writeCurve($geometry, $outer);
        }

        if ($geometry instanceof Polygon) {
            return $this->writePolygon($geometry, $outer);
        }

        if ($geometry instanceof CompoundCurve) {
            return $this->writeComposedGeometry($geometry, $outer);
        }

        if ($geometry instanceof CurvePolygon) {
            return $this->writeComposedGeometry($geometry, $outer);
        }

        if ($geometry instanceof GeometryCollection) {
            return $this->writeComposedGeometry($geometry, $outer);
        }

        if ($geometry instanceof PolyhedralSurface) {
            return $this->writeComposedGeometry($geometry, $outer);
        }

        throw GeometryIOException::unsupportedGeometryType($geometry->geometryType());
    }

    /**
     * @param int $uint
     *
     * @return string
     */
    protected function packUnsignedInteger(int $uint) : string
    {
        return pack($this->byteOrder === WKBTools::BIG_ENDIAN ? 'N' : 'V', $uint);
    }

    /**
     * @param Geometry $geometry
     * @param bool     $outer
     *
     * @return string
     */
    abstract protected function packHeader(Geometry $geometry, bool $outer) : string;

    /**
     * @return string
     */
    private function packByteOrder() : string
    {
        return pack('C', $this->byteOrder);
    }

    /**
     * @param float $double
     *
     * @return string
     */
    private function packDouble(float $double) : string
    {
        $binary = pack('d', $double);

        if ($this->byteOrder !== $this->machineByteOrder) {
            return strrev($binary);
        }

        return $binary;
    }

    /**
     * @param Point $point
     *
     * @throws GeometryIOException
     * @return string
     */
    private function packPoint(Point $point) : string
    {
        if ($point->isEmpty()) {
            throw new GeometryIOException('Empty points have no WKB representation.');
        }

        $binary = $this->packDouble($point->x()).$this->packDouble($point->y());

        if (null !== $z = $point->z()) {
            $binary .= $this->packDouble($z);
        }
        if (null !== $m = $point->m()) {
            $binary .= $this->packDouble($m);
        }

        return $binary;
    }

    /**
     * @param Curve $curve
     *
     * @return string
     */
    private function packCurve(Curve $curve) : string
    {
        $wkb = $this->packUnsignedInteger($curve->count());

        foreach ($curve as $point) {
            $wkb .= $this->packPoint($point);
        }

        return $wkb;
    }

    /**
     * @param Point $point
     * @param bool  $outer
     *
     * @return string
     */
    private function writePoint(Point $point, $outer) : string
    {
        $wkb = $this->packByteOrder();
        $wkb .= $this->packHeader($point, $outer);
        $wkb .= $this->packPoint($point);

        return $wkb;
    }

    /**
     * @param Curve $curve
     * @param bool  $outer
     *
     * @return string
     */
    private function writeCurve(Curve $curve, bool $outer) : string
    {
        $wkb = $this->packByteOrder();
        $wkb .= $this->packHeader($curve, $outer);
        $wkb .= $this->packCurve($curve);

        return $wkb;
    }

    /**
     * @param Polygon $polygon
     * @param bool    $outer
     *
     * @return string
     */
    private function writePolygon(Polygon $polygon, bool $outer) : string
    {
        $wkb = $this->packByteOrder();
        $wkb .= $this->packHeader($polygon, $outer);
        $wkb .= $this->packUnsignedInteger($polygon->count());

        foreach ($polygon as $ring) {
            $wkb .= $this->packCurve($ring);
        }

        return $wkb;
    }

    /**
     * @param Geometry $collection
     * @param bool     $outer
     *
     * @return string
     */
    private function writeComposedGeometry(Geometry $collection, bool $outer) : string
    {
        $wkb = $this->packByteOrder();
        $wkb .= $this->packHeader($collection, $outer);
        $wkb .= $this->packUnsignedInteger($collection->count());

        foreach ($collection as $geometry) {
            $wkb .= $this->doWrite($geometry, false);
        }

        return $wkb;
    }
}
