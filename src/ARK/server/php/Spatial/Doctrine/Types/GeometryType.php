<?php

namespace ARK\Spatial\Doctrine\Types;

use ARK\Spatial\Geometry\Geometry;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Doctrine type for Geometry.
 */
class GeometryType extends Type
{
    /**
     * The default SRID to use for geometries when talking to the database.
     *
     * This is the SRID that will be used when retrieving geometries from the database,
     * as the WKT and WKB formats do not include the SRID information.
     *
     * Due to current limitations in Doctrine, this will also be used when sending geometries to the database,
     * in place of the actual SRID of the geometry.
     *
     * @see http://www.doctrine-project.org/jira/browse/DDC-3319
     *
     * @var int
     */
    public static $srid = 0;

    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return 'Geometry';
    }

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) : string
    {
        if ($platform->getName() === 'postgresql') {
            return 'GEOMETRY';
        }

        return mb_strtoupper($this->getName());
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValueSQL(string $sqlExpr, AbstractPlatform $platform) : string
    {
        return sprintf('ST_GeomFromWKB(%s, %d)', $sqlExpr, self::$srid);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValueSQL(string $sqlExpr, $platform) : string
    {
        return sprintf('ST_AsBinary(%s)', $sqlExpr);
    }

    /**
     * {@inheritdoc}
     */
    public function canRequireSQLConversion() : bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform) : bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getBindingType() : int
    {
        return \PDO::PARAM_LOB;
    }
}
