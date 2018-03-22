<?php

namespace ARK\Spatial\Engine;

use ARK\Spatial\Exception\GeometryEngineException;
use ARK\Spatial\Geometry\Geometry;
use ARK\Spatial\Spatial\MultiPolygon;
use ARK\Spatial\Geometry\Point;

/**
 * Interface for geometry engines.
 */
interface GeometryEngineInterface
{
    /**
     * Checks whether a geometry is valid, as defined by the OGC specification.
     *
     * For example, a polygon with self-intersecting rings is invalid.
     *
     * @param Geometry $g the geometry
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return bool                    whether the geometry is valid
     */
    public function isValid(Geometry $g) : bool;

    /**
     * Returns true if the geometry has no anomalous geometric points, such as self intersection or self tangency.
     *
     * @param Geometry $g the geometry
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return bool                    whether the geometry is simple
     */
    public function isSimple(Geometry $g) : bool;

    /**
     * Returns true if the geometry is closed.
     *
     * @param Geometry $g the geometry
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return bool                    whether the geometry is closed
     */
    public function isClosed(Geometry $g) : bool;

    /**
     * Returns a geometry representing the bounding box of the supplied geometry.
     *
     * @param Geometry $g the geometry
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return Geometry                the envelope of the geometry
     */
    public function envelope(Geometry $g) : Geometry;

    /**
     * Returns the closure of the combinatorial boundary of a Geometry.
     *
     * @param Geometry $g the geometry
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return Geometry                the boundary of the geometry
     */
    public function boundary(Geometry $g) : Geometry;

    /**
     * Returns true if the given geometries represent the same geometry.
     *
     * @param Geometry $a the first geometry
     * @param Geometry $b the second geometry
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return bool                    whether the geometries are spatially equal
     */
    public function equals(Geometry $a, Geometry $b) : bool;

    /**
     * Returns true if the given geometries do not spatially intersect.
     *
     * Geometries spatially intersect if they share any portion of space.
     *
     * @param Geometry $a the first geometry
     * @param Geometry $b the second geometry
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return bool                    whether the geometries are disjoint
     */
    public function disjoint(Geometry $a, Geometry $b) : bool;

    /**
     * Returns true if the given geometries spatially intersect.
     *
     * Geometries spatially intersect if they share any portion of space.
     *
     * @param Geometry $a the first geometry
     * @param Geometry $b the second geometry
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return bool                    whether the geometries intersect
     */
    public function intersects(Geometry $a, Geometry $b) : bool;

    /**
     * Returns true if the geometries have at least one point in common, but their interiors do not intersect.
     *
     * @param Geometry $a the first geometry
     * @param Geometry $b the second geometry
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return bool                    whether the geometries touch
     */
    public function touches(Geometry $a, Geometry $b) : bool;

    /**
     * Returns true if the supplied geometries have some, but not all, interior points in common.
     *
     * @param Geometry $a the first geometry
     * @param Geometry $b the second geometry
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return bool                    whether the geometries cross
     */
    public function crosses(Geometry $a, Geometry $b) : bool;

    /**
     * Returns true if the geometry $a is completely inside geometry $b.
     *
     * @param Geometry $a the first geometry
     * @param Geometry $b the second geometry
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return bool                    whether the first geometry is within the second
     */
    public function within(Geometry $a, Geometry $b) : bool;

    /**
     * Returns true if `$a` contains `$b`.
     *
     * `$a` contains `$b` if and only if no points of `$b` lie in the exterior of `$a`,
     * and at least one point of the interior of `$b` lies in the interior of `$a`.
     *
     * @param Geometry $a the first geometry
     * @param Geometry $b the second geometry
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return bool                    whether the first geometry contains the second
     */
    public function contains(Geometry $a, Geometry $b) : bool;

    /**
     * Returns true if the two geometries overlap.
     *
     * The geometries overlap if they share space, are of the same dimension,
     * but are not completely contained by each other.
     *
     * @param Geometry $a the first geometry
     * @param Geometry $b the second geometry
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return bool                    whether the geometries overlap
     */
    public function overlaps(Geometry $a, Geometry $b) : bool;

    /**
     * Returns true if `$a` is spatially related to `$b`.
     *
     * Tests for intersections between the Interior, Boundary and Exterior
     * of the two geometries as specified by the values in the intersectionMatrixPattern.
     *
     * @param Geometry $a      the first geometry
     * @param Geometry $b      the second geometry
     * @param string   $matrix the DE-9IM matrix pattern
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return bool                    whether the geometries relate according to the matrix pattern
     */
    public function relate(Geometry $a, Geometry $b, string $matrix) : bool;

    /**
     * Returns a derived geometry collection value with elements that match the specified measure.
     *
     * @param Geometry $g      the geometry
     * @param float    $mValue the m coordinate value
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return Geometry                the elements that match the measure
     */
    public function locateAlong(Geometry $g, float $mValue) : Geometry;

    /**
     * Returns a derived geometry collection value with elements that match the specified range of measures inclusively.
     *
     * @param Geometry $g      the geometry
     * @param float    $mStart the start of m coordinates
     * @param float    $mEnd   the end of m coordinates
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return Geometry                the elements that match the measures
     */
    public function locateBetween(Geometry $g, float $mStart, float $mEnd) : Geometry;

    /**
     * Returns the 2-dimensional cartesian minimum distance between two geometries in projected units.
     *
     * The distance is based on spatial ref.
     *
     * @param Geometry $a the first geometry
     * @param Geometry $b the second geometry
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return float                   the distance between the geometries
     */
    public function distance(Geometry $a, Geometry $b) : float;

    /**
     * Returns a geometry that represents all points whose distance from this Geometry is <= distance.
     *
     * @param Geometry $g        the geometry
     * @param float    $distance the buffer distance
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return Geometry                the buffer geometry
     */
    public function buffer(Geometry $g, float $distance) : Geometry;

    /**
     * Returns the minimum convex geometry that encloses all geometries within the set.
     *
     * @param Geometry $g the geometry
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return Geometry                the convex hull geometry
     */
    public function convexHull(Geometry $g) : Geometry;

    /**
     * Returns a geometry that represents the shared portion of `$a` and `$b`.
     *
     * @param Geometry $a the first geometry
     * @param Geometry $b the second geometry
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return Geometry                the intersection of the geometries
     */
    public function intersection(Geometry $a, Geometry $b) : Geometry;

    /**
     * Returns a geometry that represents the point set union of the geometries.
     *
     * @param Geometry $a the first geometry
     * @param Geometry $b the second geometry
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return Geometry                the union of the geometries
     */
    public function union(Geometry $a, Geometry $b) : Geometry;

    /**
     * Returns a geometry that represents the portions of `$a` and `$b` that do not intersect.
     *
     * @param Geometry $a the first geometry
     * @param Geometry $b the second geometry
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return Geometry                the symmetric difference of the geometries
     */
    public function symDifference(Geometry $a, Geometry $b) : Geometry;

    /**
     * Returns a geometry that represents that part of `$a` that does not intersect with `$b`.
     *
     * @param Geometry $a the first geometry
     * @param Geometry $b the second geometry
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return Geometry                the difference of the geometries
     */
    public function difference(Geometry $a, Geometry $b) : Geometry;

    /**
     * Returns the length of a Curve or MultiCurve in its associated spatial reference.
     *
     * @param Geometry $g the Curve or MultiCurve
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return float                   the length of the geometry
     */
    public function length(Geometry $g) : float;

    /**
     * Returns the area of a Surface or MultiSurface in its SRID units.
     *
     * @param Geometry $g the Surface or MultiSurface
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return float                   the area of the geometry
     */
    public function area(Geometry $g) : float;

    /**
     * Returns the geometric center of a Surface or MultiSurface.
     *
     * @param Geometry $g the Surface or MultiSurface
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return Point                   the centroid of the geometry
     */
    public function centroid(Geometry $g) : Point;

    /**
     * Returns a Point guaranteed to be on a Surface or MultiSurface.
     *
     * @param Geometry $g the Surface or MultiSurface
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return Point                   a point of the surface of the geometry
     */
    public function pointOnSurface(Geometry $g) : Point;

    /**
     * Returns the collection of polygons that bounds the given polygon 'p' for any polygon 'p' in the surface.
     *
     * @param Geometry $g
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return MultiPolygon
     */
    public function boundingPolygons(Geometry $g) : MultiPolygon;

    /**
     * Snap all points of the input geometry to a regular grid.
     *
     * @param Geometry $g    the geometry
     * @param float    $size the grid size
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return Geometry                the snapped geometry
     */
    public function snapToGrid(Geometry $g, float $size) : Geometry;

    /**
     * Returns a "simplified" version of the given geometry using the Douglas-Peucker algorithm.
     *
     * @param Geometry $g         the geometry
     * @param float    $tolerance the tolerance
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return Geometry                the simplified geometry
     */
    public function simplify(Geometry $g, float $tolerance) : Geometry;

    /**
     * Returns the 2-dimensional largest distance between two geometries in projected units.
     *
     * @param Geometry $a the first geometry
     * @param Geometry $b the second geometry
     *
     * @throws GeometryEngineException if the operation is not supported by the engine
     * @return float                   the max distance between the geometries
     */
    public function maxDistance(Geometry $a, Geometry $b) : float;
}
