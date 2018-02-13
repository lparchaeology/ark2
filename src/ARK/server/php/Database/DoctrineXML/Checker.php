<?php

namespace ARK\Database\DoctrineXML;

use DoctrineXml\Checker as XmlChecker;
use Exception;

class Checker extends XmlChecker
{
    protected static function getSchema()
    {
        static $cache = null;
        if (!isset($cache)) {
            $schemaFile = __DIR__.'/doctrine-xml-0.6.xsd';
            $s = (is_file($schemaFile) && is_readable($schemaFile)) ? @file_get_contents($schemaFile) : false;
            if ($s === false) {
                throw new Exception('Failed to load the schema file '.$schemaFile);
            }
            $cache = $s;
        }

        return $cache;
    }
}
