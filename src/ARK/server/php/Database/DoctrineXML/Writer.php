<?php

/**
 * ARK Database Schema Writer.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
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
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Database\DoctrineXML;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Schema\AbstractAsset;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Doctrine\DBAL\Schema\Index;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Exception;
use ReflectionClass;
use SimpleXMLElement;

class Writer
{
    /**
     * @param Connection    $connection
     * @param string        $filename
     * @param bool          $replaceIfExists
     * @param callable|null $tableFilter
     *
     * @throws Exception
     *
     * @return string
     */
    public static function fromConnection(
        Connection $connection,
        string $filename = '',
        bool $replaceIfExists = false,
        callable $tableFilter = null
    ) : string {
        $schema = $connection->getSchemaManager()->createSchema();
        $platform = $connection->getDatabasePlatform();
        return static::toDocument($connection, $schema, $platform, $filename, $replaceIfExists, $tableFilter);
    }

    /**
     * @param string           $filename
     * @param bool             $replaceIfExists
     * @param AbstractPlatform $platform
     * @param callable|null    $tableFilter
     *
     * @throws Exception
     *
     * @return string
     */
    public static function fromSchema(
        Schema $schema,
        AbstractPlatform $platform,
        string $filename = '',
        bool $replaceIfExists = false,
        callable $tableFilter = null
    ) : string {
        return static::toDocument(null, $schema, $platform, $filename, $replaceIfExists, $tableFilter);
    }

    public static function toDocument(
        Connection $connection,
        Schema $schema,
        AbstractPlatform $platform,
        string $filename = '',
        bool $replaceIfExists = false,
        callable $tableFilter = null
    ) : string {
        if ($filename && !$replaceIfExists && is_file($filename)) {
            throw new Exception('File '.$filename.' already exists');
        }
        $header = '<?xml version="1.0" encoding="UTF-8"?>';
        $ns = 'http://www.concrete5.org/doctrine-xml/0.6';
        $xsi = 'http://www.w3.org/2001/XMLSchema-instance';
        $xsd = 'http://concrete5.github.io/doctrine-xml/doctrine-xml-0.6.xsd';
        $doc = "$header\n<schema xmlns=\"$ns\" xmlns:xsi=\"$xsi\" xsi:schemaLocation=\"$ns $xsd\"></schema>";
        $root = new SimpleXMLElement($doc);
        $tables = $schema->getTables();
        foreach ($tables as $table) {
            if (isset($tableFilter) && ($tableFilter($table->getName()) === false)) {
                continue;
            }
            static::addTable($root, $table, $platform, $connection);
        }
        $xml = $root->asXML();
        $xml = Normalizer::normalizeString($xml);
        $errors = Checker::checkString($xml);
        if (isset($errors)) {
            throw new Exception(implode("\n", $errors));
        }
        if ($xml === false) {
            throw new Exception('Error reading schema');
        }
        if ($filename && !file_put_contents($filename, $xml)) {
            throw new Exception('Writing file '.$filename.' failed');
        }
        return $xml;
    }

    protected static function addTable(
        SimpleXMLElement $parent,
        Table $table,
        AbstractPlatform $platform,
        Connection $connection
    ) : void {
        $element = $parent->addChild('table');
        static::addNameAttribute($element, $table);
        $options = $table->getOptions();
        if (isset($options['comment'])) {
            $element->addAttribute('comment', $options['comment']);
            unset($options['comment']);
        }
        $options = static::tableOptions($table, $options, $connection, $platform);
        // Primary Key
        if ($table->hasPrimaryKey()) {
            $primaryKey = $table->getPrimaryKey();
            $primaryFields = $primaryKey->getColumns();
            $primaryIndex = $primaryKey->getName();
        } else {
            $primaryFields = [];
            $primaryIndex = '';
        }
        // Fields
        // Table::getProperty() modifies the order, so get direct access
        //$fields = $table->getColumns();
        $tableRefl = new ReflectionClass(Table::class);
        $columnRefl = $tableRefl->getProperty('_columns');
        $columnRefl->setAccessible(true);
        $fields = $columnRefl->getValue($table);
        foreach ($fields as $field) {
            static::addField($element, $field, $primaryFields, $options, $platform);
        }
        // Indexes
        $indexes = $table->getIndexes();
        foreach ($indexes as $index) {
            if ($index->getName() !== $primaryIndex) {
                static::addIndex($element, $index);
            }
        }
        // Foreign Keys
        $foreignKeys = $table->getForeignKeys();
        foreach ($foreignKeys as $foreignKey) {
            static::addForeignKey($element, $foreignKey);
        }
        // Platform Options
        static::addOptions($element, $options, $platform);
    }

    protected static function addField(
        SimpleXMLElement $parent,
        Column $field,
        iterable $primaryFields,
        iterable $tableOptions,
        AbstractPlatform $platform
    ) : void {
        $element = $parent->addChild('field');
        static::addNameAttribute($element, $field);
        $options = $field->getPlatformOptions();
        $type = $field->getType()->getName();
        $size = $field->getLength();
        switch ($type) {
            case 'datetime':
                // TODO needed???
                if (isset($options['version']) && $options['version']) {
                    $type = 'timestamp';
                    unset($options['version']);
                }
                break;
            case 'decimal':
            case 'float':
                $size = $field->getPrecision().'.'.$field->getScale();
                break;
        }
        $element->addAttribute('type', $type);
        if ($size !== null) {
            $element->addAttribute('size', $size);
        }
        $comment = $field->getComment();
        if ($comment) {
            $element->addAttribute('comment', $comment);
        }
        if ($field->getUnsigned()) {
            $element->addChild('unsigned');
        }
        if ($field->getAutoincrement()) {
            $element->addChild('autoincrement');
        }
        $default = $field->getDefault();
        if ($default !== null && $default !== 'NULL') {
            if ($type === 'date' || $type === 'time' || $type === 'timestamp' || $type === 'datetime') {
                $element->addChild('deftimestamp');
            } else {
                $def = $element->addChild('default');
                $def->addAttribute('value', trim($default, "'"));
            }
        }
        if (in_array($field->getName(), $primaryFields, true)) {
            $element->addChild('key');
        }
        if ($field->getNotnull()) {
            $element->addChild('notnull');
        }
        if ($field->getFixed()) {
            $element->addChild('fixed');
        }
        // Platform Options
        foreach ($tableOptions as $key => $value) {
            if (isset($options[$key]) && $options[$key] === $value) {
                unset($options[$key]);
            }
            if ($key === 'collate' && isset($options['collation']) && $options['collation'] === $value) {
                unset($options['collation']);
            }
        }
        static::addOptions($element, $options, $platform);
    }

    protected static function addIndex(SimpleXMLElement $parent, Index $index) : void
    {
        $element = $parent->addChild('index');
        static::addNameAttribute($element, $index);
        $columns = $index->getColumns();
        if ($index->isUnique()) {
            $element->addChild('unique');
        }
        if ($index->hasFlag('FULLTEXT')) {
            $element->addChild('fulltext');
        }
        if ($index->hasFlag('SPATIAL')) {
            $element->addChild('spatial');
        }
        foreach ($columns as $column) {
            $element->addChild('col', $column);
        }
    }

    protected static function addForeignKey(SimpleXMLElement $parent, ForeignKeyConstraint $foreignKey) : void
    {
        $element = $parent->addChild('references');
        static::addNameAttribute($element, $foreignKey);
        $element->addAttribute('table', $foreignKey->getForeignTableName());
        if ($foreignKey->hasOption('onUpdate')) {
            $element->addAttribute('onupdate', $foreignKey->getOption('onUpdate'));
        }
        if ($foreignKey->hasOption('onDelete')) {
            $element->addAttribute('ondelete', $foreignKey->getOption('onDelete'));
        }
        $local = $foreignKey->getLocalColumns();
        $foreign = $foreignKey->getForeignColumns();
        $columns = array_combine($local, $foreign);
        foreach ($columns as $local => $foreign) {
            $col = $element->addChild('column');
            $col->addAttribute('local', $local);
            $col->addAttribute('foreign', $foreign);
        }
    }

    protected static function addNameAttribute(SimpleXMLElement $element, AbstractAsset $asset) : void
    {
        $name = $asset->getName();
        if ($name) {
            $element->addAttribute('name', $name);
        }
    }

    protected static function addOptions(SimpleXMLElement $element, iterable $options, AbstractPlatform $platform) : void
    {
        if (count($options)) {
            $opt = $element->addChild('opt');
            $opt->addAttribute('for', $platform->getName());
            foreach ($options as $key => $value) {
                $opt->addAttribute($key, $value);
            }
        }
    }

    protected static function tableOptions(
        Table $table,
        iterable $options,
        Connection $connection,
        AbstractPlatform $platform
    ) : iterable {
        if ($connection === null) {
            return $options;
        }
        if ($platform->getName() === 'mysql') {
            $sql = 'SELECT * FROM information_schema.TABLES WHERE TABLE_SCHEMA = :database AND TABLE_NAME = :table';
            $stmt = $connection->prepare($sql);
            $stmt->bindValue('database', $connection->getDatabase());
            $stmt->bindValue('table', $table->getName());
            $stmt->execute();
            $data = $stmt->fetch();
            if (!isset($options['engine'])) {
                $options['engine'] = $data['ENGINE'];
            }
            if (!isset($options['collate'])) {
                $options['collate'] = $data['TABLE_COLLATION'];
            }
            if (!isset($options['character set'])) {
                $sql = 'SELECT * FROM information_schema.COLLATIONS WHERE COLLATION_NAME = :collate';
                $stmt = $connection->prepare($sql);
                $stmt->bindValue('collate', $options['collate']);
                $stmt->execute();
                $data = $stmt->fetch();
                $options['charset'] = $data['CHARACTER_SET_NAME'];
            }
        }
        return $options;
    }
}
