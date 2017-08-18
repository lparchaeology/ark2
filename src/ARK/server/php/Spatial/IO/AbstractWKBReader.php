<?php

namespace ARK\Spatial\IO;

use ARK\Spatial\Exception\GeometryIOException;
use ARK\Spatial\Geometry\CircularString;
use ARK\Spatial\Geometry\CompoundCurve;
use ARK\Spatial\Geometry\CoordinateSystem;
use ARK\Spatial\Geometry\CurvePolygon;
use ARK\Spatial\Geometry\Geometry;
use ARK\Spatial\Geometry\GeometryCollection;
use ARK\Spatial\Geometry\LineString;
use ARK\Spatial\Geometry\MultiLineString;
use ARK\Spatial\Geometry\MultiPoint;
use ARK\Spatial\Geometry\MultiPolygon;
use ARK\Spatial\Geometry\Point;
use ARK\Spatial\Geometry\Polygon;
use ARK\Spatial\Geometry\PolyhedralSurface;
use ARK\Spatial\Geometry\TIN;
use ARK\Spatial\Geometry\Triangle;

/**
 * Base class for WKBReader and EWKBReader.
 */
abstract class AbstractWKBReader
{
    /**
     * @param WKBBuffer $buffer       the WKB buffer
     * @param int       $geometryType a variable to store the geometry type
     * @param bool      $hasZ         a variable to store whether the geometry has Z coordinates
     * @param bool      $hasM         a variable to store whether the geometry has M coordinates
     * @param int       $srid         a variable to store the SRID
     *
     *
     * @throws GeometryIOException
     */
    abstract protected function readGeometryHeader(WKBBuffer $buffer, int &$geometryType, bool &$hasZ, bool &$hasM, int &$srid) : void;

    /**
     * @param WKBBuffer $buffer
     * @param int       $srid
     *
     * @throws GeometryIOException
     * @return Geometry
     */
    protected function readGeometry(WKBBuffer $buffer, int $srid) : Geometry
    {
        $buffer->readByteOrder();

        $this->readGeometryHeader($buffer, $geometryType, $hasZ, $hasM, $srid);

        $cs = new CoordinateSystem($hasZ, $hasM, $srid);

        switch ($geometryType) {
            case Geometry::POINT:
                return $this->readPoint($buffer, $cs);

            case Geometry::LINESTRING:
                return $this->readLineString($buffer, $cs);

            case Geometry::CIRCULARSTRING:
                return $this->readCircularString($buffer, $cs);

            case Geometry::COMPOUNDCURVE:
                return $this->readCompoundCurve($buffer, $cs);

            case Geometry::POLYGON:
                return $this->readPolygon($buffer, $cs);

            case Geometry::CURVEPOLYGON:
                return $this->readCurvePolygon($buffer, $cs);

            case Geometry::MULTIPOINT:
                return $this->readMultiPoint($buffer, $cs);

            case Geometry::MULTILINESTRING:
                return $this->readMultiLineString($buffer, $cs);

            case Geometry::MULTIPOLYGON:
                return $this->readMultiPolygon($buffer, $cs);

            case Geometry::GEOMETRYCOLLECTION:
                return $this->readGeometryCollection($buffer, $cs);

            case Geometry::POLYHEDRALSURFACE:
                return $this->readPolyhedralSurface($buffer, $cs);

            case Geometry::TIN:
                return $this->readTIN($buffer, $cs);

            case Geometry::TRIANGLE:
                return $this->readTriangle($buffer, $cs);
        }

        throw GeometryIOException::unsupportedGeometryType($geometryType);
    }

    /**
     * @param WKBBuffer        $buffer
     * @param CoordinateSystem $cs
     *
     * @return Point
     */
    private function readPoint(WKBBuffer $buffer, CoordinateSystem $cs) : Point
    {
        $coords = $buffer->readDoubles($cs->coordinateDimension());

        return new Point($cs, ...$coords);
    }

    /**
     * @param WKBBuffer        $buffer
     * @param CoordinateSystem $cs
     *
     * @return LineString
     */
    private function readLineString(WKBBuffer $buffer, CoordinateSystem $cs) : LineString
    {
        $numPoints = $buffer->readUnsignedLong();

        $points = [];

        for ($i = 0; $i < $numPoints; ++$i) {
            $points[] = $this->readPoint($buffer, $cs);
        }

        return new LineString($cs, ...$points);
    }

    /**
     * @param WKBBuffer        $buffer
     * @param CoordinateSystem $cs
     *
     * @return CircularString
     */
    private function readCircularString(WKBBuffer $buffer, CoordinateSystem $cs) : CircularString
    {
        $numPoints = $buffer->readUnsignedLong();

        $points = [];

        for ($i = 0; $i < $numPoints; ++$i) {
            $points[] = $this->readPoint($buffer, $cs);
        }

        return new CircularString($cs, ...$points);
    }

    /**
     * @param WKBBuffer        $buffer
     * @param CoordinateSystem $cs
     *
     * @return CompoundCurve
     */
    private function readCompoundCurve(WKBBuffer $buffer, CoordinateSystem $cs) : CompoundCurve
    {
        $numCurves = $buffer->readUnsignedLong();
        $curves = [];

        for ($i = 0; $i < $numCurves; ++$i) {
            $curves[] = $this->readGeometry($buffer, $cs->SRID());
        }

        return new CompoundCurve($cs, ...$curves);
    }

    /**
     * @param WKBBuffer        $buffer
     * @param CoordinateSystem $cs
     *
     * @return Polygon
     */
    private function readPolygon(WKBBuffer $buffer, CoordinateSystem $cs) : Polygon
    {
        $numRings = $buffer->readUnsignedLong();

        $rings = [];

        for ($i = 0; $i < $numRings; ++$i) {
            $rings[] = $this->readLineString($buffer, $cs);
        }

        return new Polygon($cs, ...$rings);
    }

    /**
     * @param WKBBuffer        $buffer
     * @param CoordinateSystem $cs
     *
     * @return CurvePolygon
     */
    private function readCurvePolygon(WKBBuffer $buffer, CoordinateSystem $cs) : CurvePolygon
    {
        $numRings = $buffer->readUnsignedLong();

        $rings = [];

        for ($i = 0; $i < $numRings; ++$i) {
            $rings[] = $this->readGeometry($buffer, $cs->SRID());
        }

        return new CurvePolygon($cs, ...$rings);
    }

    /**
     * @param WKBBuffer        $buffer
     * @param CoordinateSystem $cs
     *
     * @return MultiPoint
     */
    private function readMultiPoint(WKBBuffer $buffer, CoordinateSystem $cs) : MultiPoint
    {
        $numPoints = $buffer->readUnsignedLong();
        $points = [];

        for ($i = 0; $i < $numPoints; ++$i) {
            $points[] = $this->readGeometry($buffer, $cs->SRID());
        }

        return new MultiPoint($cs, ...$points);
    }

    /**
     * @param WKBBuffer        $buffer
     * @param CoordinateSystem $cs
     *
     * @return MultiLineString
     */
    private function readMultiLineString(WKBBuffer $buffer, CoordinateSystem $cs) : MultiLineString
    {
        $numLineStrings = $buffer->readUnsignedLong();
        $lineStrings = [];

        for ($i = 0; $i < $numLineStrings; ++$i) {
            $lineStrings[] = $this->readGeometry($buffer, $cs->SRID());
        }

        return new MultiLineString($cs, ...$lineStrings);
    }

    /**
     * @param WKBBuffer        $buffer
     * @param CoordinateSystem $cs
     *
     * @return MultiPolygon
     */
    private function readMultiPolygon(WKBBuffer $buffer, CoordinateSystem $cs) : MultiPolygon
    {
        $numPolygons = $buffer->readUnsignedLong();
        $polygons = [];

        for ($i = 0; $i < $numPolygons; ++$i) {
            $polygons[] = $this->readGeometry($buffer, $cs->SRID());
        }

        return new MultiPolygon($cs, ...$polygons);
    }

    /**
     * @param WKBBuffer        $buffer
     * @param CoordinateSystem $cs
     *
     * @return GeometryCollection
     */
    private function readGeometryCollection(WKBBuffer $buffer, CoordinateSystem $cs) : GeometryCollection
    {
        $numGeometries = $buffer->readUnsignedLong();
        $geometries = [];

        for ($i = 0; $i < $numGeometries; ++$i) {
            $geometries[] = $this->readGeometry($buffer, $cs->SRID());
        }

        return new GeometryCollection($cs, ...$geometries);
    }

    /**
     * @param WKBBuffer        $buffer
     * @param CoordinateSystem $cs
     *
     * @return PolyhedralSurface
     */
    private function readPolyhedralSurface(WKBBuffer $buffer, CoordinateSystem $cs) : PolyhedralSurface
    {
        $numPatches = $buffer->readUnsignedLong();
        $patches = [];

        for ($i = 0; $i < $numPatches; ++$i) {
            $patches[] = $this->readGeometry($buffer, $cs->SRID());
        }

        return new PolyhedralSurface($cs, ...$patches);
    }

    /**
     * @param WKBBuffer        $buffer
     * @param CoordinateSystem $cs
     *
     * @return TIN
     */
    private function readTIN(WKBBuffer $buffer, CoordinateSystem $cs) : TIN
    {
        $numPatches = $buffer->readUnsignedLong();
        $patches = [];

        for ($i = 0; $i < $numPatches; ++$i) {
            $patches[] = $this->readGeometry($buffer, $cs->SRID());
        }

        return new TIN($cs, ...$patches);
    }

    /**
     * @param WKBBuffer        $buffer
     * @param CoordinateSystem $cs
     *
     * @return Triangle
     */
    private function readTriangle(WKBBuffer $buffer, CoordinateSystem $cs) : Triangle
    {
        $numRings = $buffer->readUnsignedLong();

        $rings = [];

        for ($i = 0; $i < $numRings; ++$i) {
            $rings[] = $this->readLineString($buffer, $cs);
        }

        return new Triangle($cs, ...$rings);
    }
}
