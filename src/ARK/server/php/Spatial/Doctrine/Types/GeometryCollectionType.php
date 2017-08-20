<?php

namespace ARK\Spatial\Doctrine\Types;

/**
 * Doctrine type for GeometryCollection.
 */
class GeometryCollectionType extends GeometryType
{
    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return 'GeometryCollection';
    }
}
