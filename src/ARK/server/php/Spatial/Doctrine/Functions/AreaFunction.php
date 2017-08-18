<?php

namespace ARK\Spatial\Doctrine\Functions;

/**
 * Area() function.
 */
class AreaFunction extends AbstractFunction
{
    /**
     * {@inheritdoc}
     */
    protected function getSqlFunctionName()
    {
        return 'ST_Area';
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameterCount()
    {
        return 1;
    }
}
