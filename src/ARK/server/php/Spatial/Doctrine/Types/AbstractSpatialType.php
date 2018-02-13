<?php

/**
 * ARK Spatial Type.
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

namespace ARK\Spatial\Doctrine\Types;

//use ARK\Spatial\Geometry\Geometry;
use ARK\Spatial\Exception\InvalidValueException;
use Brick\Geo\Geometry;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

abstract class AbstractSpatialType extends Type
{
    public static $srid = 0;

    abstract public function getGeometryName() : string;

    abstract public function getSqlName() : string;

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) : string
    {
        if ($platform->getName() === 'postgresql') {
            return 'GEOMETRY';
        }
        return $this->getSqlName();
    }

    public function getMappedDatabaseTypes(AbstractPlatform $platform)
    {
        return [$this->getName()];
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }
        if (is_resource($value)) {
            $value = stream_get_contents($value);
        }
        return Geometry::fromBinary($value, self::$srid);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }
        if ($value instanceof Geometry) {
            return $value->asBinary();
        }
        throw new InvalidValueException();
    }

    public function convertToDatabaseValueSQL($sqlExpr, AbstractPlatform $platform) : string
    {
        return sprintf('ST_GeomFromWKB(%s, %d)', $sqlExpr, self::$srid);
    }

    public function convertToPHPValueSQL($sqlExpr, $platform) : string
    {
        return sprintf('ST_AsBinary(%s)', $sqlExpr);
    }

    public function canRequireSQLConversion() : bool
    {
        return true;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) : bool
    {
        return true;
    }

    public function getBindingType() : int
    {
        return \PDO::PARAM_LOB;
    }
}
