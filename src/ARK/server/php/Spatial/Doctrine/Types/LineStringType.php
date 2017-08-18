<?php

namespace ARK\Spatial\Doctrine\Types;

use ARK\Spatial\Geometry\Proxy\LineStringProxy;

/**
 * Doctrine type for LineString.
 */
class LineStringType extends GeometryType
{
    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return 'LineString';
    }

    /**
     * {@inheritdoc}
     */
    protected function getProxyClassName() : string
    {
        return LineStringProxy::class;
    }
}
