<?php

namespace ARK\Spatial\Doctrine\Types;

class LineStringType extends GeometryType
{
    public function getName() : string
    {
        return 'LineString';
    }
}
