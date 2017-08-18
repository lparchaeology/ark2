<?php

namespace ARK\Spatial\Doctrine\Types;

use ARK\Spatial\Proxy\MultiPointProxy;

/**
 * Doctrine type for MultiPoint.
 */
class MultiPointType extends GeometryType
{
    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return 'MultiPoint';
    }

    /**
     * {@inheritdoc}
     */
    protected function getProxyClassName() : string
    {
        return MultiPointProxy::class;
    }
}
