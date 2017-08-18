<?php

namespace ARK\Spatial\Doctrine\Functions;

/**
 * Intersects() function.
 */
class IntersectsFunction extends AbstractFunction
{
    /**
     * {@inheritdoc}
     */
    protected function getSqlFunctionName() : string
    {
        return 'ST_Intersects';
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameterCount() : int
    {
        return 2;
    }
}
