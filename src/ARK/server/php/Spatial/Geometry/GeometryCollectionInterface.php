<?php

namespace ARK\Spatial\Geometry;

/**
 * A GeometryCollection is a geometric object that is a collection of some number of geometric objects.
 *
 * All the elements in a GeometryCollection shall be in the same Spatial Reference System. This is also the Spatial
 * Reference System for the GeometryCollection.
 *
 * GeometryCollection places no other constraints on its elements. Subclasses of GeometryCollection may restrict
 * membership based on dimension and may also place other constraints on the degree of spatial overlap between
 * elements.
 *
 * By the nature of digital representations, collections are inherently ordered by the underlying storage mechanism.
 * Two collections whose difference is only this order are spatially equal and will return equivalent results in any
 * geometric-defined operations.
 */
interface GeometryCollectionInterface
{
    /**
     * Returns the number of geometries in this GeometryCollection.
     *
     * @return int
     */
    public function numGeometries() : int;

    /**
     * Returns the specified geometry N in this GeometryCollection.
     *
     * @param int $n the geometry number, 1-based
     *
     * @throws NoSuchGeometryException if there is no Geometry at this index
     * @return Geometry
     */
    public function geometryN(int $n) : Geometry;
}
