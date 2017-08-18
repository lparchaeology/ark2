<?php

namespace Brick\Geo\Doctrine\Types;

use Brick\Geo\Proxy\PointProxy;

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
