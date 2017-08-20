<?php

namespace ARK\Spatial\Geometry;

/**
 * A Polygon is a planar Surface defined by 1 exterior boundary and 0 or more interior boundaries.
 *
 * Each interior boundary defines a hole in the Polygon.
 *
 * The exterior boundary linear ring defines the “top” of the surface which is the side of the surface from which the
 * exterior boundary appears to traverse the boundary in a counter clockwise direction. The interior linear rings will
 * have the opposite orientation, and appear as clockwise when viewed from the “top”.
 *
 * The assertions for Polygons (the rules that define valid Polygons) are as follows:
 *
 * a) Polygons are topologically closed;
 * b) The boundary of a Polygon consists of a set of linear rings that make up its exterior and interior boundaries;
 * c) No two Rings in the boundary cross and the Rings in the boundary of a Polygon may intersect at a Point but
 * only as a tangent;
 * d) A Polygon may not have cut lines, spikes or punctures;
 * e) The interior of every Polygon is a connected point set;
 * f) The exterior of a Polygon with 1 or more holes is not connected. Each hole defines a connected component of
 * the exterior.
 *
 * In the above assertions, interior, closure and exterior have the standard topological definitions. The combination
 * of (a) and (c) makes a Polygon a regular closed Point set. Polygons are simple geometric objects.
 */
interface PolygonInterface
{
    /**
     * Returns the exterior ring of this Polygon.
     *
     * @throws EmptyGeometryException
     * @return LineString
     */
    public function exteriorRing() : LineString;

    /**
     * Returns the number of interior rings in this Polygon.
     *
     * @return int
     */
    public function numInteriorRings() : int;

    /**
     * Returns the specified interior ring N in this Polygon.
     *
     * @param int $n the ring number, 1-based
     *
     * @throws NoSuchGeometryException if there is no interior ring at this index
     * @return LineString
     */
    public function interiorRingN(int $n) : LineString;
}
