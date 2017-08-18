<?php

namespace ARK\Spatial\Doctrine\Functions;

/**
 * ConvexHull() function.
 */
class ConvexHullFunction extends AbstractFunction
{
    /**
     * {@inheritdoc}
     */
    protected function getSqlFunctionName() : string
    {
        return 'ST_ConvexHull';
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameterCount() : int
    {
        return 1;
    }
}
