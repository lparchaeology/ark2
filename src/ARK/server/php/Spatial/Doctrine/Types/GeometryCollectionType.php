<?php

namespace ARK\Spatial\Doctrine\Types;

class GeometryCollectionType extends GeometryType
{
    public function getName() : string
    {
        return 'GeometryCollection';
    }
}
