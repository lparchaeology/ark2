<?php

namespace ARK\Spatial;

use ARK\Spatial\Engine\GeometryEngineRegistry;
use ARK\Spatial\Exception\CoordinateSystemException;
use ARK\Spatial\Exception\GeometryIOException;
use ARK\Spatial\Exception\InvalidGeometryException;
use ARK\Spatial\Exception\UnexpectedGeometryException;
use ARK\Spatial\IO\WKBReader;
use ARK\Spatial\IO\WKBWriter;
use ARK\Spatial\IO\WKTReader;
use ARK\Spatial\IO\WKTWriter;

/**
 * Geometry is the root class of the hierarchy.
 */
abstract class Geometry implements GeometryInterface, \Countable, \IteratorAggregate
{
    public const GEOMETRY = 0;
    public const POINT = 1;
    public const LINESTRING = 2;
    public const POLYGON = 3;
    public const MULTIPOINT = 4;
    public const MULTILINESTRING = 5;
    public const MULTIPOLYGON = 6;
    public const GEOMETRYCOLLECTION = 7;
    public const CIRCULARSTRING = 8;
    public const COMPOUNDCURVE = 9;
    public const CURVEPOLYGON = 10;
    public const MULTICURVE = 11;
    public const MULTISURFACE = 12;
    public const CURVE = 13;
    public const SURFACE = 14;
    public const POLYHEDRALSURFACE = 15;
    public const TIN = 16;
    public const TRIANGLE = 17;

    protected static $types = [
        CIRCULARSTRING => [
            'type' => 'CircularString',
            'code' => CIRCULARSTRING,
            'class' => CircularString::class,
            'proxy' => CircularStringProxy::class,
            'element' => POINT,
            'dimension' => 1,
            'abstract' => false,
        ],
        COMPOUNDCURVE => [
            'type' => 'CompoundCurve',
            'code' => COMPOUNDCURVE,
            'class' => CompoundCurve::class,
            'proxy' => CompoundCurveProxy::class,
            'element' => CURVE,
            'dimension' => 1,
            'abstract' => false,
        ],
        CURVE => [
            'type' => 'Curve',
            'code' => CURVE,
            'class' => Curve::class,
            'proxy' => null,
            'element' => POINT,
            'dimension' => 1,
            'abstract' => true,
        ],
        CURVEPOLYGON => [
            'type' => 'CurvePolygon',
            'code' => CURVEPOLYGON,
            'class' => CurvePolygon::class,
            'proxy' => CurvePolygonProxy::class,
            'element' => CURVE,
            'dimension' => 2,
            'abstract' => false,
        ],
        GEOMETRY => [
            'type' => 'Geometry',
            'code' => GEOMETRY,
            'class' => self::class,
            'proxy' => null,
            'element' => null,
            'dimension' => null,
            'abstract' => true,
        ],
        GEOMETRYCOLLECTION => [
            'type' => 'GeometryCollection',
            'code' => GEOMETRYCOLLECTION,
            'class' => GeometryCollection::class,
            'proxy' => GeometryCollectionProxy::class,
            'element' => GEOMETRY,
            'dimension' => null,
            'abstract' => false,
        ],
        LINESTRING => [
            'type' => 'LineString',
            'code' => LINESTRING,
            'class' => LineString::class,
            'proxy' => LineStringProxy::class,
            'element' => POINT,
            'dimension' => 1,
            'abstract' => false,
        ],
        MULTICURVE => [
            'type' => 'MultiCurve',
            'code' => MULTICURVE,
            'class' => MultiCurve::class,
            'proxy' => null,
            'element' => CURVE,
            'dimension' => 1,
            'abstract' => true,
        ],
        MULTILINESTRING => [
            'type' => 'MultiLineString',
            'code' => MULTILINESTRING,
            'class' => MultiLineString::class,
            'proxy' => MultiLineStringProxy::class,
            'element' => LINESTRING,
            'dimension' => 1,
            'abstract' => false,
        ],
        MULTIPOINT => [
            'type' => 'MultiPoint',
            'code' => MULTIPOINT,
            'class' => MultiPoint::class,
            'proxy' => MultiPointProxy::class,
            'element' => POINT,
            'dimension' => 0,
            'abstract' => false,
        ],
        MULTIPOLYGON => [
            'type' => 'MultiPolygon',
            'code' => MULTIPOLYGON,
            'class' => MultiPolygon::class,
            'proxy' => MultiPolygonProxy::class,
            'element' => POLYGON,
            'dimension' => 2,
            'abstract' => false,
        ],
        MULTISURFACE => [
            'type' => 'MultiSurface',
            'code' => MULTISURFACE,
            'class' => MultiSurface::class,
            'proxy' => null,
            'element' => SURFACE,
            'dimension' => 2,
            'abstract' => true,
        ],
        POINT => [
            'type' => 'Point',
            'code' => POINT,
            'class' => Point::class,
            'proxy' => PointProxy::class,
            'element' => null,
            'dimension' => 0,
            'abstract' => false,
        ],
        POLYGON => [
            'type' => 'Polygon',
            'code' => POLYGON,
            'class' => Polygon::class,
            'proxy' => PolygonProxy::class,
            'element' => LINESTRING,
            'dimension' => 2,
            'abstract' => false,
        ],
        POLYHEDRALSURFACE => [
            'type' => 'PolyhedralSurface',
            'code' => POLYHEDRALSURFACE,
            'class' => PolyhedralSurface::class,
            'proxy' => PolyhedralSurfaceProxy::class,
            'element' => POLYGON,
            'dimension' => 2,
            'abstract' => false,
        ],
        SURFACE => [
            'type' => 'Surface',
            'code' => SURFACE,
            'class' => Surface::class,
            'proxy' => null,
            'element' => LINESTRING,
            'dimension' => 2,
            'abstract' => true,
        ],
        TIN => [
            'type' => 'TIN',
            'code' => TIN,
            'class' => TIN::class,
            'proxy' => TINProxy::class,
            'element' => TRIANGLE,
            'dimension' => 2,
            'abstract' => false,
        ],
        TRIANGLE => [
            'type' => 'Triangle',
            'code' => TRIANGLE,
            'class' => Triangle::class,
            'proxy' => TriangleProxy::class,
            'element' => LINESTRING,
            'dimension' => 2,
            'abstract' => false,
        ],
    ];

    /**
     * The type of this geometry.
     *
     * @var string
     */
    protected $type;

    /**
     * The elements that comprise this Geometry.
     *
     * This array can be empty.
     *
     * @var Geometry[]
     */
    protected $elements = [];

    /**
     * The coordinate system of this geometry.
     *
     * @var CoordinateSystem
     */
    protected $coordinateSystem;

    /**
     * Whether this geometry is empty.
     *
     * @var bool
     */
    protected $isEmpty;

    /**
     * Returns a text representation of this geometry.
     *
     * @noproxy
     *
     * @return string
     */
    final public function __toString() : string
    {
        return $this->asText();
    }

    /**
     * Returns the coordinate system of this geometry.
     *
     * @return CoordinateSystem
     */
    public function coordinateSystem() : CoordinateSystem
    {
        return $this->coordinateSystem;
    }

    /**
     * Returns the class of the Geometry elements.
     *
     * @return string
     */
    public function elementType() : string
    {
        return self::$types[$this->type]['element'];
    }

    /**
     * Returns the class of the Geometry elements.
     *
     * @return string
     */
    public function elementClass() : string
    {
        return self::$types[$this->elementType()]['class'];
    }

    /**
     * Returns the elements of the Geometry.
     *
     * @return Geometry[]
     */
    public function elements() : iterable
    {
        return $this->elements;
    }

    /**
     * Returns the specified element N of the Geometry.
     *
     * @param int $n the element number, 1-based. Negative numbers count from end.
     *
     * @throws NoSuchGeometryException if there is no Point at this index
     * @return Geometry
     */
    public function element(int $n) : Geometry
    {
        $n = ($n < 0 ? $n + $this->count() : $n - 1);
        if (!isset($this->elements[$n])) {
            throw new NoSuchGeometryException('There is no element in this Geometry at index '.$n);
        }
        return $this->elements[$n];
    }

    /**
     * Returns the raw coordinates of this geometry as an array.
     *
     * @return array
     */
    public function toArray() : array
    {
        $result = [];
        foreach ($this->elements as $element) {
            $result[] = $element->toArray();
        }
        return $result;
    }

    /**
     * Builds a Geometry from a WKT representation.
     *
     * If the resulting geometry is valid but is not an instance of the class this method is called on,
     * for example passing a Polygon WKT to Point::fromText(), an exception is thrown.
     *
     * @param string $wkt  the Well-Known Text representation
     * @param int    $srid the optional SRID to use
     *
     * @throws GeometryIOException         if the given string is not a valid WKT representation
     * @throws CoordinateSystemException   if the WKT contains mixed coordinate systems
     * @throws InvalidGeometryException    if the WKT represents an invalid geometry
     * @throws UnexpectedGeometryException if the resulting geometry is not an instance of the current class
     * @return static
     */
    public static function fromText(string $wkt, int $srid = 0) : Geometry
    {
        static $wktReader;

        if ($wktReader === null) {
            $wktReader = new WKTReader();
        }

        $geometry = $wktReader->read($wkt, $srid);

        if (!$geometry instanceof static) {
            throw UnexpectedGeometryException::unexpectedGeometryType(static::class, $geometry);
        }

        return $geometry;
    }

    /**
     * Builds a Geometry from a WKB representation.
     *
     * If the resulting geometry is valid but is not an instance of the class this method is called on,
     * for example passing a Polygon WKB to Point::fromBinary(), an exception is thrown.
     *
     * @param string $wkb  the Well-Known Binary representation
     * @param int    $srid the optional SRID to use
     *
     * @throws GeometryIOException         if the given string is not a valid WKB representation
     * @throws CoordinateSystemException   if the WKB contains mixed coordinate systems
     * @throws InvalidGeometryException    if the WKB represents an invalid geometry
     * @throws UnexpectedGeometryException if the resulting geometry is not an instance of the current class
     * @return static
     */
    public static function fromBinary(string $wkb, int $srid = 0) : Geometry
    {
        static $wkbReader;

        if ($wkbReader === null) {
            $wkbReader = new WKBReader();
        }

        $geometry = $wkbReader->read($wkb, $srid);

        if (!$geometry instanceof static) {
            throw UnexpectedGeometryException::unexpectedGeometryType(static::class, $geometry);
        }

        return $geometry;
    }

    // Countable interface

    /**
     * Returns the number of elements in this Geometry.
     *
     * Required by interface Countable.
     *
     * {@inheritdoc}
     */
    public function count() : int
    {
        return count($this->elements);
    }

    // IteratorAggregate interface

    /**
     * Returns an iterator for the elements in this Geometry.
     *
     * Required by interface IteratorAggregate.
     *
     * {@inheritdoc}
     */
    public function getIterator() : \ArrayIterator
    {
        return new \ArrayIterator($this->elements);
    }

    // GeometryInterface

    /**
     * @noproxy
     *
     * {@inheritdoc}
     */
    public function dimension() : int
    {
        return self::$types[$this->type]['dimension'];
    }

    /**
     * {@inheritdoc}
     */
    public function coordinateDimension() : int
    {
        return $this->coordinateSystem->coordinateDimension();
    }

    /**
     * {@inheritdoc}
     */
    public function spatialDimension() : int
    {
        return $this->coordinateSystem->spatialDimension();
    }

    /**
     * @noproxy
     *
     * {@inheritdoc}
     */
    public function geometryType() : string
    {
        return $this->type;
    }

    /**
     * @noproxy
     *
     * {@inheritdoc}
     */
    public function geometryCode() : int
    {
        return self::$types[$this->type]['code'];
    }

    /**
     * {@inheritdoc}
     */
    public function SRID() : int
    {
        return $this->coordinateSystem->SRID();
    }

    /**
     * {@inheritdoc}
     */
    public function envelope() : Geometry
    {
        return GeometryEngineRegistry::get()->envelope($this);
    }

    /**
     * {@inheritdoc}
     */
    public function asText() : string
    {
        static $wktWriter;

        if ($wktWriter === null) {
            $wktWriter = new WKTWriter();
        }

        return $wktWriter->write($this);
    }

    /**
     * {@inheritdoc}
     */
    public function asBinary() : string
    {
        static $wkbWriter;

        if ($wkbWriter === null) {
            $wkbWriter = new WKBWriter();
        }

        return $wkbWriter->write($this);
    }

    /**
     * {@inheritdoc}
     */
    public function isValid() : bool
    {
        return GeometryEngineRegistry::get()->isValid($this);
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty() : bool
    {
        return $this->isEmpty;
    }

    /**
     * {@inheritdoc}
     */
    public function isSimple() : bool
    {
        return GeometryEngineRegistry::get()->isSimple($this);
    }

    /**
     * {@inheritdoc}
     */
    public function is3D() : bool
    {
        return $this->coordinateSystem->hasZ();
    }

    /**
     * {@inheritdoc}
     */
    public function isMeasured() : bool
    {
        return $this->coordinateSystem->hasM();
    }

    /**
     * {@inheritdoc}
     */
    public function boundary() : Geometry
    {
        return GeometryEngineRegistry::get()->boundary($this);
    }

    /**
     * {@inheritdoc}
     */
    public function equals(Geometry $geometry) : bool
    {
        return GeometryEngineRegistry::get()->equals($this, $geometry);
    }

    /**
     * {@inheritdoc}
     */
    public function disjoint(Geometry $geometry) : bool
    {
        return GeometryEngineRegistry::get()->disjoint($this, $geometry);
    }

    /**
     * {@inheritdoc}
     */
    public function intersects(Geometry $geometry) : bool
    {
        return GeometryEngineRegistry::get()->intersects($this, $geometry);
    }

    /**
     * {@inheritdoc}
     */
    public function touches(Geometry $geometry) : bool
    {
        return GeometryEngineRegistry::get()->touches($this, $geometry);
    }

    /**
     * {@inheritdoc}
     */
    public function crosses(Geometry $geometry) : bool
    {
        return GeometryEngineRegistry::get()->crosses($this, $geometry);
    }

    /**
     * {@inheritdoc}
     */
    public function within(Geometry $geometry) : bool
    {
        return GeometryEngineRegistry::get()->within($this, $geometry);
    }

    /**
     * {@inheritdoc}
     */
    public function contains(Geometry $geometry) : bool
    {
        return GeometryEngineRegistry::get()->contains($this, $geometry);
    }

    /**
     * {@inheritdoc}
     */
    public function overlaps(Geometry $geometry) : bool
    {
        return GeometryEngineRegistry::get()->overlaps($this, $geometry);
    }

    /**
     * {@inheritdoc}
     */
    public function relate(Geometry $geometry, string $matrix) : bool
    {
        return GeometryEngineRegistry::get()->relate($this, $geometry, $matrix);
    }

    /**
     * {@inheritdoc}
     */
    public function locateAlong(float $mValue) : Geometry
    {
        return GeometryEngineRegistry::get()->locateAlong($this, $mValue);
    }

    /**
     * {@inheritdoc}
     */
    public function locateBetween(float $mStart, float $mEnd) : Geometry
    {
        return GeometryEngineRegistry::get()->locateBetween($this, $mStart, $mEnd);
    }

    /**
     * {@inheritdoc}
     */
    public function distance(Geometry $geometry) : float
    {
        return GeometryEngineRegistry::get()->distance($this, $geometry);
    }

    /**
     * {@inheritdoc}
     */
    public function buffer(float $distance) : Geometry
    {
        return GeometryEngineRegistry::get()->buffer($this, $distance);
    }

    /**
     * {@inheritdoc}
     */
    public function convexHull() : Geometry
    {
        return GeometryEngineRegistry::get()->convexHull($this);
    }

    /**
     * {@inheritdoc}
     */
    public function intersection(Geometry $geometry) : Geometry
    {
        return GeometryEngineRegistry::get()->intersection($this, $geometry);
    }

    /**
     * {@inheritdoc}
     */
    public function union(Geometry $geometry) : Geometry
    {
        return GeometryEngineRegistry::get()->union($this, $geometry);
    }

    /**
     * {@inheritdoc}
     */
    public function difference(Geometry $geometry) : Geometry
    {
        return GeometryEngineRegistry::get()->difference($this, $geometry);
    }

    /**
     * {@inheritdoc}
     */
    public function symDifference(Geometry $geometry) : Geometry
    {
        return GeometryEngineRegistry::get()->symDifference($this, $geometry);
    }

    /**
     * {@inheritdoc}
     */
    public function snapToGrid(float $size) : Geometry
    {
        return GeometryEngineRegistry::get()->snapToGrid($this, $size);
    }

    /**
     * {@inheritdoc}
     */
    public function simplify(float $tolerance) : Geometry
    {
        return GeometryEngineRegistry::get()->simplify($this, $tolerance);
    }

    /**
     * {@inheritdoc}
     */
    public function maxDistance(Geometry $geometry) : float
    {
        return GeometryEngineRegistry::get()->maxDistance($this, $geometry);
    }

    /**
     * Initialise the class members.
     *
     * @param CoordinateSystem $coordinateSystem the coordinate system of this geometry
     * @param CoordinateSystem $cs
     * @param Geometry         ...$elements
     */
    protected function init(int $code, CoordinateSystem $coordinateSystem, iterable $elements = []) : void
    {
        $this->code = $code;
        $this->coordinateSystem = $coordinateSystem;
        $this->elements = $elements;
        $this->isEmpty = !$elements;
        if (!$this->isEmpty) {
            CoordinateSystem::check($this, ...$this->elements);
            $this->validate();
        }
    }

    /**
     * Validate the class members.
     */
    protected function validate() : void
    {
    }
}
