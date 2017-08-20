<?php

namespace ARK\Spatial\Doctrine\Types;

/**
 * Doctrine type for Point.
 */
class PointType extends GeometryType
{
    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return 'Point';
    }
}
