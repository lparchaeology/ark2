<?php

namespace ARK\Spatial\Doctrine\Types;

//use ARK\Spatial\Geometry\Geometry;
use Brick\Geo\Geometry;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

abstract class AbstractSpatialType extends Type
{
    public static $srid = 0;

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) : string
    {
        if ($platform->getName() === 'postgresql') {
            return 'GEOMETRY';
        }
        return mb_strtoupper($this->getName());
    }

    public function getMappedDatabaseTypes(AbstractPlatform $platform)
    {
        return [mb_strtolower($this->getName())];
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

        $type = is_object($value) ? get_class($value) : gettype($value);

        throw new \UnexpectedValueException(sprintf('Expected %s, got %s.', Geometry::class, $type));
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
