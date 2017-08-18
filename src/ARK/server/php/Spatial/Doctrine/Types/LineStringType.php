<?php

namespace ARK\Spatial\Doctrine\Types;

use ARK\Spatial\Proxy\LineStringProxy;

/**
 * Doctrine type for LineString.
 */
class LineStringType extends GeometryType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'LineString';
    }

    /**
     * {@inheritdoc}
     */
    protected function getProxyClassName()
    {
        return LineStringProxy::class;
    }
}
