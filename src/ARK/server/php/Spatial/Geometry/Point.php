<?php

namespace ARK\Spatial\Geometry;

use ARK\Spatial\Exception\InvalidGeometryException;

/**
 * {@inheritdoc}
 */
class Point extends Geometry implements PointInterface
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
        $this->init(Geometry::POINT, $cs, $coords ?? []);
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
     * {@inheritdoc}
     */
    public function x() : ?float
    {
        return $this->x;
    }

    /**
     * {@inheritdoc}
     */
    public function y() : ?float
    {
        return $this->y;
    }

    /**
     * {@inheritdoc}
     */
    public function z() : ?float
    {
        return $this->z;
    }

    /**
     * {@inheritdoc}
     */
    public function m() : ?float
    {
        return $this->m;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return $this->elements();
    }

    /**
     * {@inheritdoc}
     */
    protected function init(int $code, CoordinateSystem $coordinateSystem, iterable $elements = null) : void
    {
        parent::init($code, $coordinateSystem, $elements);

        if (!$elements) {
            return;
        }

        $this->x = $elements[0];
        $this->y = $elements[1];

        if ($cs->hasZ() && $cs->hasM()) {
            $this->z = $elements[2];
            $this->m = $elements[3];
        } elseif ($cs->hasZ()) {
            $this->z = $elements[2];
        } elseif ($cs->hasM()) {
            $this->m = $elements[2];
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function validate() : void
    {
        if ($this->count() !== $cs->coordinateDimension()) {
            throw new InvalidGeometryException(sprintf(
                'Expected %d coordinates for Point %s, got %d.',
                $cs->coordinateDimension(),
                $cs->coordinateName(),
                $this->count()
            ));
        }
    }
}
