<?php

namespace ARK\Spatial\Engine;

use ARK\Spatial\Exception\GeometryEngineException;

/**
 * This class holds the GeometryEngine implementation to use for calculations.
 */
final class GeometryEngineRegistry
{
    /**
     * @var GeometryEngine|null
     */
    private static $engine;

    /**
     * Returns whether a geometry engine is set.
     *
     * @return bool
     */
    public static function has() : bool
    {
        return self::$engine !== null;
    }

    /**
     * Sets the GeometryEngine to use for calculations.
     *
     * @param GeometryEngine $engine
     */
    public static function set(GeometryEngine $engine) : void
    {
        self::$engine = $engine;
    }

    /**
     * Returns the GeometryEngine to use for calculations.
     *
     * @throws GeometryEngineException
     * @return GeometryEngine
     */
    public static function get() : GeometryEngine
    {
        if (self::$engine === null) {
            throw GeometryEngineException::noEngineSet();
        }

        return self::$engine;
    }
}
