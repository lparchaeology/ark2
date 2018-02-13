<?php

/**
 * ARK Database Table.
 *
 * Copyright (C) 2017  L - P : Heritage LLP.
 *
 * This file is part of ARK, the Archaeological Recording Kit.
 *
 * ARK is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ARK is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ARK.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     John Layt <j.layt@lparchaeology.com>
 * @copyright  2017 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Database;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use DoctrineXml\Checker;
use DoctrineXml\Normalizer;
use DoctrineXml\Parser as XmlParser;
use DoctrineXml\Utilities;
use Exception;
use SimpleXMLElement;

class Parser extends XmlParser
{
    public static function fromDocument($xml, AbstractPlatform $platform, $checkXml = true, $normalizeXml = false, $tableFilter = null)
    {
        if ($checkXml || $normalizeXml) {
            if (is_a($xml, '\SimpleXMLElement')) {
                $xml = $xml->asXML();
            }
            if ($normalizeXml) {
                $xml = Normalizer::normalizeString($xml);
            }
            if ($checkXml) {
                //$errors = Checker::checkString($xml);
                if (isset($errors)) {
                    throw new Exception(implode("\n", $errors));
                }
            }
        }
        if (is_a($xml, '\SimpleXMLElement')) {
            $xDoc = $xml;
        } else {
            $preUseInternalErrors = libxml_use_internal_errors(true);
            libxml_clear_errors();
            $xDoc = @simplexml_load_string($xml);
            if (!is_object($xDoc)) {
                $errors = Utilities::explainLibXmlErrors();
                libxml_clear_errors();
                libxml_use_internal_errors($preUseInternalErrors);
                throw new Exception(implode("\n", $errors));
            }
            libxml_use_internal_errors($preUseInternalErrors);
        }
        $schema = new ParserSchema();
        foreach ($xDoc->table as $xTable) {
            if (isset($tableFilter) && ($tableFilter((string) $xTable['name']) === false)) {
                continue;
            }
            static::parseTable($schema, $xTable, $platform);
        }

        return $schema;
    }

    protected static function parseIndex(Schema $schema, Table $table, SimpleXMLElement $xIndex, AbstractPlatform $platform)
    {
        $s = (string) $xIndex['name'];
        $indexName = ($s === '') ? null : $s;
        $fieldNames = [];
        foreach ($xIndex->col as $col) {
            $fieldNames[] = (string) $col;
        }
        if (isset($xIndex->unique)) {
            $table->addUniqueIndex($fieldNames, $indexName);
        } else {
            $flags = [];
            if (isset($xIndex->fulltext)) {
                $flags[] = 'FULLTEXT';
            }
            if (isset($xIndex->spatial)) {
                $flags[] = 'SPATIAL';
            }
            $table->addIndex($fieldNames, $indexName, $flags);
        }
    }
}
