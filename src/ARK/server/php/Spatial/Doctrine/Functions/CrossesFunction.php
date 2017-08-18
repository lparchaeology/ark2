<?php

namespace ARK\Spatial\Doctrine\Functions;

/**
 * Crosses() function.
 */
class CrossesFunction extends AbstractFunction
{
    /**
     * {@inheritdoc}
     */
    protected function getSqlFunctionName()
    {
        return 'ST_Crosses';
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameterCount()
    {
        return 2;
    }
}
