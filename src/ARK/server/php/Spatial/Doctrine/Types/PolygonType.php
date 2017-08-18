<?php

namespace ARK\Spatial\Doctrine\Types;

use ARK\Spatial\Proxy\PolygonProxy;

/**
 * Doctrine type for Polygon.
 */
class PolygonType extends GeometryType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Polygon';
    }

    /**
     * {@inheritdoc}
     */
    protected function getProxyClassName()
    {
        return PolygonProxy::class;
    }
}
