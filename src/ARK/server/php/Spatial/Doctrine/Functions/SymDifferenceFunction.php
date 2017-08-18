<?php

namespace ARK\Spatial\Doctrine\Functions;

/**
 * SymDifference() function.
 */
class SymDifferenceFunction extends AbstractFunction
{
    /**
     * {@inheritdoc}
     */
    protected function getSqlFunctionName() : string
    {
        return 'ST_SymDifference';
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameterCount() : int
    {
        return 2;
    }
}
