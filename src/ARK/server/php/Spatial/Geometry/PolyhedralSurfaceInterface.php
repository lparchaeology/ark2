<?php

namespace ARK\Spatial\Geometry;

/**
 * A PolyhedralSurface is a contiguous collection of polygons, which share common boundary segments.
 *
 * For each pair of polygons that "touch", the common boundary shall be expressible as a finite collection
 * of LineStrings. Each such LineString shall be part of the boundary of at most 2 Polygon patches.
 *
 * For any two polygons that share a common boundary, the "top" of the polygon shall be consistent. This means
 * that when two linear rings from these two Polygons traverse the common boundary segment, they do so in
 * opposite directions. Since the Polyhedral surface is contiguous, all polygons will be thus consistently oriented.
 * This means that a non-oriented surface (such as Möbius band) shall not have single surface representations.
 * They may be represented by a MultiSurface.
 *
 * If each such LineString is the boundary of exactly 2 Polygon patches, then the PolyhedralSurface is a simple,
 * closed polyhedron and is topologically isomorphic to the surface of a sphere. By the Jordan Surface Theorem
 * (Jordan’s Theorem for 2-spheres), such polyhedrons enclose a solid topologically isomorphic to the interior of a
 * sphere; the ball. In this case, the "top" of the surface will either point inward or outward of the enclosed
 * finite solid. If outward, the surface is the exterior boundary of the enclosed surface. If inward, the surface
 * is the interior of the infinite complement of the enclosed solid. A Ball with some number of voids (holes) inside
 * can thus be presented as one exterior boundary shell, and some number in interior boundary shells.
 */
interface PolyhedralSurfaceInterface
{
    /**
     * @return int
     */
    public function numPatches() : int;

    /**
     * Returns the specified patch N in this PolyhedralSurface.
     *
     * @param int $n the patch number, 1-based
     *
     * @throws NoSuchGeometryException if there is no patch at this index
     * @return Polygon
     */
    public function patchN(int $n) : Polygon;

    /**
     * Returns the collection of polygons in this surface that bounds the given polygon 'p' for any polygon 'p' in the surface.
     *
     * @param Polygon $p
     *
     * @throws GeometryEngineException if the operation is not supported by the geometry engine
     * @return MultiPolygon
     */
    public function boundingPolygons(Polygon $p) : MultiPolygon;

    /**
     * @throws GeometryEngineException if the operation is not supported by the geometry engine
     * @return bool
     */
    public function isClosed() : bool;
}
