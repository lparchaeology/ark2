<?php

namespace ARK\Spatial\Doctrine\Functions;

/**
 * IsClosed() function.
 */
class IsClosedFunction extends AbstractFunction
{
    /**
     * {@inheritdoc}
     */
    protected function getSqlFunctionName() : string
    {
        return 'ST_IsClosed';
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameterCount() : int
    {
        return 1;
    }
}
