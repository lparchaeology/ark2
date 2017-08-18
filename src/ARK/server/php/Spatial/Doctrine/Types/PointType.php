<?php

namespace ARK\Spatial\Doctrine\Types;

use ARK\Spatial\Geometry\Proxy\PointProxy;

/**
 * Doctrine type for Point.
 */
class PointType extends GeometryType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Point';:string
    }

    /**
     * {@inheritdoc}
     */
    protected function getProxyClassName():string
    {
        return PointProxy::class;
    }
}
