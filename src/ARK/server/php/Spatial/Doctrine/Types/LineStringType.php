<?php

namespace ARK\Spatial\Doctrine\Types;

/**
 * Doctrine type for LineString.
 */
class LineStringType extends GeometryType
{
    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return 'LineString';
    }
}
