<?php

namespace ARK\Spatial\Doctrine\Functions;

/**
 * Difference() function.
 */
class DifferenceFunction extends AbstractFunction
{
    /**
     * {@inheritdoc}
     */
    protected function getSqlFunctionName()
    {
        return 'ST_Difference';
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameterCount()
    {
        return 2;
    }
}
