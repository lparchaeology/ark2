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
    public function getName()
    {
        return 'MultiPoint';
    }

    /**
     * {@inheritdoc}
     */
    protected function getProxyClassName()
    {
        return MultiPointProxy::class;
    }
}
