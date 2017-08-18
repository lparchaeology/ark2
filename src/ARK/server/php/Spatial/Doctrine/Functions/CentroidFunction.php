<?php

namespace ARK\Spatial\Doctrine\Functions;

/**
 * Centroid() function.
 */
class CentroidFunction extends AbstractFunction
{
    /**
     * {@inheritdoc}
     */
    protected function getSqlFunctionName() : string
    {
        return 'ST_Centroid';
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameterCount() : int
    {
        return 1;
    }
}
