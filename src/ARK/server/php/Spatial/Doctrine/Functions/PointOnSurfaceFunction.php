<?php

namespace ARK\Spatial\Doctrine\Functions;

/**
 * PointOnSurface() function.
 */
class PointOnSurfaceFunction extends AbstractFunction
{
    /**
     * {@inheritdoc}
     */
    protected function getSqlFunctionName()
    {
        return 'ST_PointOnSurface';
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameterCount()
    {
        return 1;
    }
}
