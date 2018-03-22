<?php

namespace ARK\Spatial\Engine;

use ARK\Spatial\Exception\GeometryEngineException;
use ARK\Spatial\Geometry\Geometry;
use ARK\Spatial\Geometry\Point;

/**
 * Database implementation of the GeometryEngine.
 *
 * The target database must have support for GIS functions.
 */
abstract class AbstractDatabaseEngine implements GeometryEngineInterface
{
    /**
     * {@inheritdoc}
     */
    public function contains(Geometry $a, Geometry $b) : bool
    {
        return $this->queryBoolean('ST_Contains', $a, $b);
    }

    /**
     * {@inheritdoc}
     */
    public function intersects(Geometry $a, Geometry $b) : bool
    {
        return $this->queryBoolean('ST_Intersects', $a, $b);
    }

    /**
     * {@inheritdoc}
     */
    public function union(Geometry $a, Geometry $b) : Geometry
    {
        return $this->queryGeometry('ST_Union', $a, $b);
    }

    /**
     * {@inheritdoc}
     */
    public function intersection(Geometry $a, Geometry $b) : Geometry
    {
        return $this->queryGeometry('ST_Intersection', $a, $b);
    }

    /**
     * {@inheritdoc}
     */
    public function difference(Geometry $a, Geometry $b) : Geometry
    {
        return $this->queryGeometry('ST_Difference', $a, $b);
    }

    /**
     * {@inheritdoc}
     */
    public function envelope(Geometry $g) : Geometry
    {
        return $this->queryGeometry('ST_Envelope', $g);
    }

    /**
     * {@inheritdoc}
     */
    public function centroid(Geometry $g) : Point
    {
        return $this->queryGeometry('ST_Centroid', $g);
    }

    /**
     * {@inheritdoc}
     */
    public function pointOnSurface(Geometry $g) : Point
    {
        return $this->queryGeometry('ST_PointOnSurface', $g);
    }

    /**
     * {@inheritdoc}
     */
    public function length(Geometry $g) : float
    {
        return $this->queryFloat('ST_Length', $g);
    }

    /**
     * {@inheritdoc}
     */
    public function area(Geometry $g) : float
    {
        return $this->queryFloat('ST_Area', $g);
    }

    /**
     * {@inheritdoc}
     */
    public function boundary(Geometry $g) : Geometry
    {
        return $this->queryGeometry('ST_Boundary', $g);
    }

    /**
     * {@inheritdoc}
     */
    public function isValid(Geometry $g) : bool
    {
        return $this->queryBoolean('ST_IsValid', $g);
    }

    /**
     * {@inheritdoc}
     */
    public function isClosed(Geometry $g) : bool
    {
        return $this->queryBoolean('ST_IsClosed', $g);
    }

    /**
     * {@inheritdoc}
     */
    public function isSimple(Geometry $g) : bool
    {
        return $this->queryBoolean('ST_IsSimple', $g);
    }

    /**
     * {@inheritdoc}
     */
    public function equals(Geometry $a, Geometry $b) : bool
    {
        return $this->queryBoolean('ST_Equals', $a, $b);
    }

    /**
     * {@inheritdoc}
     */
    public function disjoint(Geometry $a, Geometry $b) : bool
    {
        return $this->queryBoolean('ST_Disjoint', $a, $b);
    }

    /**
     * {@inheritdoc}
     */
    public function touches(Geometry $a, Geometry $b) : bool
    {
        return $this->queryBoolean('ST_Touches', $a, $b);
    }

    /**
     * {@inheritdoc}
     */
    public function crosses(Geometry $a, Geometry $b) : bool
    {
        return $this->queryBoolean('ST_Crosses', $a, $b);
    }

    /**
     * {@inheritdoc}
     */
    public function within(Geometry $a, Geometry $b) : bool
    {
        return $this->queryBoolean('ST_Within', $a, $b);
    }

    /**
     * {@inheritdoc}
     */
    public function overlaps(Geometry $a, Geometry $b) : bool
    {
        return $this->queryBoolean('ST_Overlaps', $a, $b);
    }

    /**
     * {@inheritdoc}
     */
    public function relate(Geometry $a, Geometry $b, $matrix) : bool
    {
        return $this->queryBoolean('ST_Relate', $a, $b, $matrix);
    }

    /**
     * {@inheritdoc}
     */
    public function locateAlong(Geometry $g, float $mValue) : Geometry
    {
        return $this->queryGeometry('ST_LocateAlong', $g, $mValue);
    }

    /**
     * {@inheritdoc}
     */
    public function locateBetween(Geometry $g, float $mStart, float $mEnd) : Geometry
    {
        return $this->queryGeometry('ST_LocateBetween', $g, $mStart, $mEnd);
    }

    /**
     * {@inheritdoc}
     */
    public function distance(Geometry $a, Geometry $b) : float
    {
        return $this->queryFloat('ST_Distance', $a, $b);
    }

    /**
     * {@inheritdoc}
     */
    public function buffer(Geometry $g, float $distance) : Geometry
    {
        return $this->queryGeometry('ST_Buffer', $g, $distance);
    }

    /**
     * {@inheritdoc}
     */
    public function convexHull(Geometry $g) : Geometry
    {
        return $this->queryGeometry('ST_ConvexHull', $g);
    }

    /**
     * {@inheritdoc}
     */
    public function symDifference(Geometry $a, Geometry $b) : Geometry
    {
        return $this->queryGeometry('ST_SymDifference', $a, $b);
    }

    /**
     * {@inheritdoc}
     */
    public function snapToGrid(Geometry $g, float $size) : Geometry
    {
        return $this->queryGeometry('ST_SnapToGrid', $g, $size);
    }

    /**
     * {@inheritdoc}
     */
    public function simplify(Geometry $g, float $tolerance) : Geometry
    {
        return $this->queryGeometry('ST_Simplify', $g, $tolerance);
    }

    /**
     * {@inheritdoc}
     */
    public function maxDistance(Geometry $a, Geometry $b) : float
    {
        return $this->queryFloat('ST_MaxDistance', $a, $b);
    }

    /**
     * {@inheritdoc}
     */
    public function boundingPolygons(Geometry $g) : Geometry
    {
        throw GeometryEngineException::unimplementedMethod(__METHOD__);
    }

    /**
     * Executes a SQL query.
     *
     * @param string $query      the SQL query to execute
     * @param array  $parameters the Geometry objects or scalar values to pass as parameters
     *
     * @throws GeometryEngineException
     * @return array                   a numeric result array
     */
    abstract protected function executeQuery($query, array $parameters) : iterable;

    /**
     * Builds a SQL query for a GIS function.
     *
     * @param string $function        the SQL GIS function to execute
     * @param array  $parameters      the Geometry objects or scalar values to pass as parameters
     * @param bool   $returnsGeometry whether the GIS function returns a Geometry
     *
     * @return string
     */
    private function buildQuery($function, array $parameters, bool $returnsGeometry) : string
    {
        foreach ($parameters as &$parameter) {
            if ($parameter instanceof Geometry) {
                if ($parameter->isEmpty()) {
                    $parameter = 'ST_GeomFromText(?, ?)';
                } else {
                    $parameter = 'ST_GeomFromWKB(?, ?)';
                }
            } else {
                $parameter = '?';
            }
        }

        $parameters = implode(', ', $parameters);
        $query = sprintf('SELECT %s(%s)', $function, $parameters);

        if (!$returnsGeometry) {
            return $query;
        }

        return sprintf('
            SELECT
                CASE WHEN ST_IsEmpty(g) THEN ST_AsText(g) ELSE NULL END,
                CASE WHEN ST_IsEmpty(g) THEN NULL ELSE ST_AsBinary(g) END,
                ST_GeometryType(g),
                ST_SRID(g)
            FROM (%s AS g) AS q
        ', $query);
    }

    /**
     * Builds and executes a SQL query for a GIS function.
     *
     * @param string $function        the SQL GIS function to execute
     * @param array  $parameters      the Geometry objects or scalar values to pass as parameters
     * @param bool   $returnsGeometry whether the GIS function returns a Geometry
     *
     * @throws GeometryEngineException
     * @return array                   a numeric result array
     */
    private function query($function, array $parameters, bool $returnsGeometry) : iterable
    {
        $query = $this->buildQuery($function, $parameters, $returnsGeometry);
        $result = $this->executeQuery($query, $parameters);

        return $result;
    }

    /**
     * Queries a GIS function returning a boolean value.
     *
     * @param string $function      the SQL GIS function to execute
     * @param mixed  ...$parameters The Geometry objects or scalar values to pass as parameters.
     *
     * @throws GeometryEngineException
     * @return bool
     */
    private function queryBoolean(string $function, ...$parameters) : bool
    {
        list($result) = $this->query($function, $parameters, false);

        if ($result === null || $result === -1) { // SQLite3 returns -1 when calling a boolean GIS function on a NULL result.
            throw GeometryEngineException::operationYieldedNoResult();
        }

        return (bool) $result;
    }

    /**
     * Queries a GIS function returning a floating point value.
     *
     * @param string $function      the SQL GIS function to execute
     * @param mixed  ...$parameters The Geometry objects or scalar values to pass as parameters.
     *
     * @throws GeometryEngineException
     * @return float
     */
    private function queryFloat(string $function, ...$parameters) : float
    {
        list($result) = $this->query($function, $parameters, false);

        if ($result === null) {
            throw GeometryEngineException::operationYieldedNoResult();
        }

        return (float) $result;
    }

    /**
     * Queries a GIS function returning a Geometry object.
     *
     * @param string $function      the SQL GIS function to execute
     * @param mixed  ...$parameters The Geometry objects or scalar values to pass as parameters.
     *
     * @throws GeometryEngineException
     * @return Geometry
     */
    private function queryGeometry(string $function, ...$parameters) : Geometry
    {
        list($wkt, $wkb, $geometryType, $srid) = $this->query($function, $parameters, true);

        if ($wkt !== null) {
            return Geometry::fromText($wkt, $srid);
        }

        if ($wkb !== null) {
            if (is_resource($wkb)) {
                $wkb = stream_get_contents($wkb);
            }
            return Geometry::fromBinary($wkb, $srid);
        }

        throw GeometryEngineException::operationYieldedNoResult();
    }
}
