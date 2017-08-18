<?php

namespace ARK\Spatial\Doctrine\Types;

use ARK\Spatial\Geometry\Proxy\MultiLineStringProxy;

/**
 * Doctrine type for MultiLineString.
 */
class MultiLineStringType extends GeometryType
{
    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return 'MultiLineString';
    }

    /**
     * {@inheritdoc}
     */
    protected function getProxyClassName() : string
    {
        return MultiLineStringProxy::class;
    }
}
