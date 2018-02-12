<?php

namespace ARK\Spatial\Doctrine\Types;

class MultiPolygonType extends GeometryType
{
    public function getName() : string
    {
        return 'MultiPolygon';
    }
}
