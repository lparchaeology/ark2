<?php

namespace ARK\Spatial\Doctrine\Functions;

/**
 * Equals() function.
 */
class EqualsFunction extends AbstractFunction
{
    /**
     * {@inheritdoc}
     */
    protected function getSqlFunctionName()
    {
        return 'ST_Equals';
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameterCount()
    {
        return 2;
    }
}
