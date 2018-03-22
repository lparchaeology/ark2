<?php

namespace ARK\Spatial\Geometry;

use ARK\Spatial\Spatial;
use ARK\Spatial\Exception\CoordinateSystemException;

/**
 * {@inheritdoc}
 */
class PolyhedralSurface extends Surface implements PolyhedralSurfaceInterface
{
    /**
     * Class constructor.
     *
     * The coordinate system of each of the patches must match the one of the PolyhedralSurface.
     *
     * @param CoordinateSystem $cs         the coordinate system of the PolyhedralSurface
     * @param Polygon          ...$patches The patches that compose the PolyhedralSurface.
     *
     * @throws CoordinateSystemException if different coordinate systems are used
     */
    public function __construct(CoordinateSystem $cs, Polygon ...$patches)
    {
        $this->init(Geometry::POINT, $cs, $patches ?? []);
    }

    /**
     * Creates a non-empty PolyhedralSurface composed of the given patches.
     *
     * @param Polygon $patch1    the first patch
     * @param Polygon ...$patchN The subsequent patches, if any.
     *
     * @throws CoordinateSystemException if the patches use different coordinate systems
     * @return PolyhedralSurface
     */
    public static function of(Polygon $patch1, Polygon ...$patchN) : PolyhedralSurface
    {
        return new static($patch1->coordinateSystem(), $patch1, ...$patchN);
    }

    /**
     * {@inheritdoc}
     */
    public function numPatches() : int
    {
        return $this->count();
    }

    /**
     * {@inheritdoc}
     */
    public function patchN(int $n) : Polygon
    {
        return $this->element($n);
    }

    /**
     * {@inheritdoc}
     */
    public function boundingPolygons(Polygon $p) : MultiPolygon
    {
        return Spatial::geometry()->boundingPolygons($p);
    }

    /**
     * {@inheritdoc}
     */
    public function isClosed() : bool
    {
        return Spatial::geometry()->isClosed($this);
    }
}
