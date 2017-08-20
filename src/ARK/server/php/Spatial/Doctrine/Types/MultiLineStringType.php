<?php

namespace ARK\Spatial\Doctrine\Types;

/**
 * Doctrine type for MultiLineString.
 */
class MultiLineStringType extends GeometryType
{
    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return 'MultiLineString';
    }
}
