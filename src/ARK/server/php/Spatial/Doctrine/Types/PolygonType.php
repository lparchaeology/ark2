<?php

namespace ARK\Spatial\Doctrine\Types;

/**
 * Doctrine type for Polygon.
 */
class PolygonType extends GeometryType
{
    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return 'Polygon';
    }
}
