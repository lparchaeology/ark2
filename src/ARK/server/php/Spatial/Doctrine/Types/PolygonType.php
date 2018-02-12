<?php

namespace ARK\Spatial\Doctrine\Types;

class PolygonType extends GeometryType
{
    public function getName() : string
    {
        return 'Polygon';
    }
}
