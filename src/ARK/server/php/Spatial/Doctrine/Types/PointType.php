<?php

namespace ARK\Spatial\Doctrine\Types;

use ARK\Spatial\Proxy\PointProxy;

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
        return 'Point';
    }

    /**
     * {@inheritdoc}
     */
    protected function getProxyClassName()
    {
        return PointProxy::class;
    }
}
