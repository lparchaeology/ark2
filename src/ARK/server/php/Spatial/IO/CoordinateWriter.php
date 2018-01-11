<?php

namespace ARK\Spatial\IO;

use Brick\Geo\Geometry;

class CoordinateWriter
{
    const DECIMAL_MINUTES_PRECISION = 5;
    const DECIMAL_MINUTES_MODE = PHP_ROUND_HALF_EVEN;

    const DEFAULT_DMS_FORMAT = '%D°%M′%S″%L, %d°%m′%s″%l';
    const DEFAULT_DM_FORMAT = '%P%D %N%L, %p%d %n%l';
    const DEFAULT_UTM_FORMAT = '%Z%H %Em E %Nm N';

    const LATITUDE_SIGN = '%P';
    const LATITUDE_DIRECTION = '%L';
    const LATITUDE_DEGREES = '%D';
    const LATITUDE_MINUTES = '%M';
    const LATITUDE_SECONDS = '%S';
    const LATITUDE_DECIMAL_DEGREES = '%D';
    const LATITUDE_DECIMAL_MINUTES = '%N';

    const LONGITUDE_SIGN = '%p';
    const LONGITUDE_DIRECTION = '%l';
    const LONGITUDE_DEGREES = '%d';
    const LONGITUDE_MINUTES = '%m';
    const LONGITUDE_SECONDS = '%s';
    const LONGITUDE_DECIMAL_DEGREES = '%D';
    const LONGITUDE_DECIMAL_MINUTES = '%n';

    const UTM_ZONE = '%Z';
    const UTM_HEMISPHERE = '%H';
    const UTM_BAND = '%B';
    const UTM_EASTING = '%E';
    const UTM_NORTHING = '%N';

    private $pattern;

    public function __construct(string $pattern = DEFAULT_DMS_FORMAT)
    {
        $this->pattern = $pattern;
    }

    public function write(Geometry $geometry, string $pattern = null) : string
    {
        $pattern = $pattern ?? $this->pattern;
    }
}
