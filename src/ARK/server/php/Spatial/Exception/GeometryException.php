<?php

namespace ARK\Spatial\Exception;

/**
 * Base class for all geometry exceptions.
 *
 * This class is abstract to ensure that only fine-grained exceptions are thrown throughout the code.
 */
abstract class GeometryException extends \Exception
{
}
