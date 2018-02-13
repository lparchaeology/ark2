<?php

namespace ARK\Database\DoctrineXML;

use DoctrineXml\Normalizer as XmlNormalizer;
use DoctrineXml\Utilities;
use Exception;

class Normalizer extends XmlNormalizer
{
    protected static function getXsltDOMDocument()
    {
        static $cache = null;
        $xsltFile = __DIR__.'/doctrine-xml-0.6.xsl';
        if (!isset($cache)) {
            $s = (is_file($xsltFile) && is_readable($xsltFile)) ? @file_get_contents($xsltFile) : false;
            if ($s === false) {
                throw new Exception('Failed to load the xslt file '.$xsltFile);
            }
            $cache = $s;
        }

        return Utilities::stringToDOMDocument($cache, $xsltFile);
    }
}
