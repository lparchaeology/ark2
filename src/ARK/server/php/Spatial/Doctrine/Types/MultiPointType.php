<?php

namespace ARK\Spatial\Doctrine\Types;

class MultiPointType extends GeometryType
{
    public function getName() : string
    {
        return 'MultiPoint';
    }
}
