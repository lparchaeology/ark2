<?php

namespace ARK\Spatial;

use ARK\Spatial\Exception\InvalidGeometryException;

/**
 * A Point is a 0-dimensional geometric object and represents a single location in coordinate space.
 *
 * A Point has an x-coordinate value, a y-coordinate value.
 * If called for by the associated Spatial Reference System, it may also have coordinate values for z and m.
 *
 * The boundary of a Point is the empty set.
 */
class Point extends Geometry
{
    /**
     * The x-coordinate value for this Point, or NULL if the point is empty.
     *
     * @var float|null
     */
    private $x;

    /**
     * The y-coordinate value for this Point, or NULL if the point is empty.
     *
     * @var float|null
     */
    private $y;

    /**
     * The z-coordinate value for this Point, or NULL if it does not have one.
     *
     * @var float|null
     */
    private $z;

    /**
     * The m-coordinate value for this Point, or NULL if it does not have one.
     *
     * @var float|null
     */
    private $m;

    /**
     * @param CoordinateSystem $cs        the coordinate system
     * @param float            ...$coords The point coordinates; can be empty for an empty point.
     *
     * @throws InvalidGeometryException if the number of coordinates does not match the coordinate system
     * @return Point
     */
    public function __construct(CoordinateSystem $cs, float ...$coords)
    {
        parent::__construct($cs, !$coords);

        if ($coords) {
            if (count($coords) !== $cs->coordinateDimension()) {
                throw new InvalidGeometryException(sprintf(
                    'Expected %d coordinates for Point %s, got %d.',
                    $cs->coordinateDimension(),
                    $cs->coordinateName(),
                    count($coords)
                ));
            }

            $this->x = (float) $coords[0];
            $this->y = (float) $coords[1];

            $hasZ = $cs->hasZ();
            $hasM = $cs->hasM();

            if ($hasZ) {
                $this->z = (float) $coords[2];
            }

            if ($hasM) {
                $this->m = (float) $coords[$hasZ ? 3 : 2];
            }
        }
    }

    /**
     * Creates a point with X and Y coordinates.
     *
     * @param float $x    the X coordinate
     * @param float $y    the Y coordinate
     * @param int   $srid an optional SRID
     *
     * @return Point
     */
    public static function xy(float $x, float $y, int $srid = 0) : Point
    {
        return new self(CoordinateSystem::xy($srid), $x, $y);
    }

    /**
     * Creates a point with X, Y and Z coordinates.
     *
     * @param float $x    the X coordinate
     * @param float $y    the Y coordinate
     * @param float $z    the Z coordinate
     * @param int   $srid an optional SRID
     *
     * @return Point
     */
    public static function xyz(float $x, float $y, float $z, int $srid = 0) : Point
    {
        return new self(CoordinateSystem::xyz($srid), $x, $y, $z);
    }

    /**
     * Creates a point with X, Y and M coordinates.
     *
     * @param float $x    the X coordinate
     * @param float $y    the Y coordinate
     * @param float $m    the M coordinate
     * @param int   $srid an optional SRID
     *
     * @return Point
     */
    public static function xym(float $x, float $y, float $m, int $srid = 0) : Point
    {
        return new self(CoordinateSystem::xym($srid), $x, $y, $m);
    }

    /**
     * Creates a point with X, Y, Z and M coordinates.
     *
     * @param float $x    the X coordinate
     * @param float $y    the Y coordinate
     * @param float $z    the Z coordinate
     * @param float $m    the M coordinate
     * @param int   $srid an optional SRID
     *
     * @return Point
     */
    public static function xyzm(float $x, float $y, float $z, float $m, int $srid = 0) : Point
    {
        return new self(CoordinateSystem::xyzm($srid), $x, $y, $z, $m);
    }

    /**
     * Creates an empty Point with XY dimensionality.
     *
     * @param int $srid an optional SRID
     *
     * @return Point
     */
    public static function xyEmpty(int $srid = 0) : Point
    {
        return new self(CoordinateSystem::xy($srid));
    }

    /**
     * Creates an empty Point with XYZ dimensionality.
     *
     * @param int $srid an optional SRID
     *
     * @return Point
     */
    public static function xyzEmpty(int $srid = 0) : Point
    {
        return new self(CoordinateSystem::xyz($srid));
    }

    /**
     * Creates an empty Point with XYM dimensionality.
     *
     * @param int $srid an optional SRID
     *
     * @return Point
     */
    public static function xymEmpty(int $srid = 0) : Point
    {
        return new self(CoordinateSystem::xym($srid));
    }

    /**
     * Creates an empty Point with XYZM dimensionality.
     *
     * @param int $srid an optional SRID
     *
     * @return Point
     */
    public static function xyzmEmpty(int $srid = 0) : Point
    {
        return new self(CoordinateSystem::xyzm($srid));
    }

    /**
     * Returns the x-coordinate value for this Point.
     *
     * Returns NULL if the Point is empty.
     *
     * @return float|null
     */
    public function x() : ?float
    {
        return $this->x;
    }

    /**
     * Returns the y-coordinate value for this Point.
     *
     * Returns NULL if the Point is empty.
     *
     * @return float|null
     */
    public function y() : ?float
    {
        return $this->y;
    }

    /**
     * Returns the z-coordinate value for this Point.
     *
     * Returns NULL if the Point is empty, or does not have a Z coordinate.
     *
     * @return float|null
     */
    public function z() : ?float
    {
        return $this->z;
    }

    /**
     * Returns the m-coordinate value for this Point.
     *
     * Returns NULL if the Point is empty, or does not have a M coordinate.
     *
     * @return float|null
     */
    public function m() : ?float
    {
        return $this->m;
    }

    /**
     * @noproxy
     *
     * {@inheritdoc}
     */
    public function geometryType() : string
    {
        return 'Point';
    }

    /**
     * @noproxy
     *
     * {@inheritdoc}
     */
    public function geometryTypeBinary() : int
    {
        return Geometry::POINT;
    }

    /**
     * @noproxy
     *
     * {@inheritdoc}
     */
    public function dimension() : int
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        if ($this->isEmpty) {
            return [];
        }

        $result = [$this->x, $this->y];

        if ($this->z !== null) {
            $result[] = $this->z;
        }

        if ($this->m !== null) {
            $result[] = $this->m;
        }

        return $result;
    }

    /**
     * Returns the number of coordinates in this Point.
     *
     * Required by interface Countable.
     *
     * {@inheritdoc}
     */
    public function count() : int
    {
        if ($this->isEmpty) {
            return 0;
        }

        return $this->coordinateSystem->coordinateDimension();
    }

    /**
     * Returns an iterator for the coordinates in this Point.
     *
     * Required by interface IteratorAggregate.
     *
     * {@inheritdoc}
     */
    public function getIterator() : \ArrayIterator
    {
        return new \ArrayIterator($this->toArray());
    }
}
