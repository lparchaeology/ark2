<?php

namespace ARK\Spatial\Doctrine\Types;

class PointType extends GeometryType
{
    public function getName() : string
    {
        return 'Point';
    }
}
