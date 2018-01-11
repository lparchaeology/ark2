<?php

namespace ARK\Spatial\IO;

use Brick\Geo\Geometry;

abstract class AbstractWriter
{
    abstract public function write(Geometry $geometry) : string;
}
