<?php

namespace ARK\Spatial\Doctrine\Types;

use ARK\Spatial\Geometry\Geometry;

class GeometryType extends AbstractSpatialType
{
    public function getName() : string
    {
        return 'Geometry';
    }
}
