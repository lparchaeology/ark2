<?php

namespace ARK\Spatial\Doctrine\Types;

use ARK\Spatial\Proxy\MultiPolygonProxy;

/**
 * Doctrine type for MultiPolygon.
 */
class MultiPolygonType extends GeometryType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'MultiPolygon';
    }

    /**
     * {@inheritdoc}
     */
    protected function getProxyClassName()
    {
        return MultiPolygonProxy::class;
    }
}
