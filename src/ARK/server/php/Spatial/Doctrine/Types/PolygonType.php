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
    public function getName() : string
    {
        return 'Polygon';
    }

    /**
     * {@inheritdoc}
     */
    protected function getProxyClassName() : string
    {
        return PolygonProxy::class;
    }
}
