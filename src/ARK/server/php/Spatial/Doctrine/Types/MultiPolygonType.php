<?php

namespace ARK\Spatial\Doctrine\Types;

/**
 * Doctrine type for MultiPolygon.
 */
class MultiPolygonType extends GeometryType
{
    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return 'MultiPolygon';
    }
}
