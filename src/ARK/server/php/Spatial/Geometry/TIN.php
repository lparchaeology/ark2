<?php

namespace ARK\Spatial\Geometry;

use ARK\Spatial\Exception\UnexpectedGeometryException;

/**
 * A TIN (triangulated irregular network) is a PolyhedralSurface consisting only of Triangle patches.
 */
class TIN extends PolyhedralSurface
{
    /**
     * {@inheritdoc}
     *
     * @throws UnexpectedGeometryException if the patches are not triangles
     */
    public function __construct(CoordinateSystem $cs, Polygon ...$patches)
    {
        $this->init(Geometry::TIN, $cs, $patches ?? []);
    }

    /**
     * {@inheritdoc}
     */
    protected function validate() : void
    {
        foreach ($this->elements() as $patch) {
            if (!$patch instanceof Triangle) {
                throw new UnexpectedGeometryException('The patches in a TIN must be triangles.');
            }
        }
    }
}
