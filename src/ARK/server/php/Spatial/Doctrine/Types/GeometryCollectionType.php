<?php

namespace ARK\Spatial\Doctrine\Types;

use ARK\Spatial\Proxy\GeometryCollectionProxy;

/**
 * Doctrine type for GeometryCollection.
 */
class GeometryCollectionType extends GeometryType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'GeometryCollection';
    }

    /**
     * {@inheritdoc}
     */
    protected function getProxyClassName()
    {
        return GeometryCollectionProxy::class;
    }
}
