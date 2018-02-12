<?php

namespace ARK\Spatial\Doctrine\Types;

class MultiLineStringType extends GeometryType
{
    public function getName() : string
    {
        return 'MultiLineString';
    }
}
