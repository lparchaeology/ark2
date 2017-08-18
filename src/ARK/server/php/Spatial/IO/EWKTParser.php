<?php

namespace ARK\Spatial\IO;

/**
 * Parser for the Extended WKT format designed by PostGIS.
 */
class EWKTParser extends WKTParser
{
    public const T_SRID = 1;
    public const T_WORD = 2;
    public const T_NUMBER = 3;

    public const REGEX_SRID = 'SRID\=([0-9]+)\s*;';

    /**
     * @return int
     */
    public function getOptionalSRID() : int
    {
        $token = current($this->tokens);

        if ($token === false) {
            return 0;
        }
        if ($token[0] !== self::T_SRID) {
            return 0;
        }

        next($this->tokens);

        return (int) $token[1];
    }

    /**
     * {@inheritdoc}
     */
    protected function getRegex() : iterable
    {
        return [
            self::T_SRID => self::REGEX_SRID,
            self::T_WORD => self::REGEX_WORD,
            self::T_NUMBER => self::REGEX_NUMBER,
        ];
    }
}
