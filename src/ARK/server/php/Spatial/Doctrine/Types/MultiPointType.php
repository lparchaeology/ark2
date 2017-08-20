<?php

namespace ARK\Spatial\Doctrine\Types;

/**
 * Doctrine type for MultiPoint.
 */
class MultiPointType extends GeometryType
{
    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return 'MultiPoint';
    }
}
