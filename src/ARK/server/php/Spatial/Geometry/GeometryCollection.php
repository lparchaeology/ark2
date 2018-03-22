<?php

namespace ARK\Spatial\Geometry;

use ARK\Spatial\Exception\CoordinateSystemException;
use ARK\Spatial\Exception\UnexpectedGeometryException;

/**
 * {@inheritdoc}
 */
class GeometryCollection extends Geometry
{
    /**
     * The dimension of this geometry.
     *
     * @var int
     */
    protected $dimension;

    /**
     * Class constructor.
     *
     * @param CoordinateSystem $cs
     * @param Geometry         ...$geometries
     *
     * @throws CoordinateSystemException   if different coordinate systems are used
     * @throws UnexpectedGeometryException if a geometry is not a valid type for a sub-class of GeometryCollection
     */
    public function __construct(CoordinateSystem $cs, Geometry ...$geometries)
    {
        $this->init(Geometry::GEOMETRYCOLLECTION, $cs, $geometries ?? []);
    }

    /**
     * Creates a non-empty GeometryCollection composed of the given geometries.
     *
     * @param Geometry $geometry1    the first geometry
     * @param Geometry ...$geometryN The subsequent geometries, if any.
     *
     * @throws CoordinateSystemException   if the geometries use different coordinate systems
     * @throws UnexpectedGeometryException if a geometry is not a valid type for a sub-class of GeometryCollection
     * @return static
     */
    public static function of(Geometry $geometry1, Geometry ...$geometryN)
    {
        return new static($geometry1->coordinateSystem(), $geometry1, ...$geometryN);
    }

    // GeometryCollectionInterface

    /**
     * {@inheritdoc}
     */
    public function numGeometries() : int
    {
        return $this->count();
    }

    /**
     * {@inheritdoc}
     */
    public function geometryN(int $n) : Geometry
    {
        return $this->element($n);
    }

    /**
     * {@inheritdoc}
     */
    protected function validate() : void
    {
        $this->dimension = 0;
        $this->isEmpty = true;
        $elementClass = $this->elementClass();
        foreach ($this->elements() as $element) {
            if (!$element->isEmpty()) {
                $this->isEmpty = false;
            }
            $dimension = $element->dimension();
            if ($dimension > $this->dimension) {
                $this->dimension = $dimension;
            }
            if (!$element instanceof $elementClass) {
                throw new UnexpectedGeometryException(sprintf(
                    '%s expects instance of %s, instance of %s given.',
                    $this->type(),
                    $elementClass,
                    $element->type()
                ));
            }
        }
    }
}
