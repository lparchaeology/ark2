<?php

namespace ARK\Spatial\Engine;

use ARK\Spatial\Exception\GeometryEngineException;
use ARK\Spatial\Exception\SQLite3Exception;
use ARK\Spatial\Geometry\Geometry;

/**
 * Database engine based on a SQLite3 driver.
 *
 * The spatialite extension must be loaded in this driver.
 */
class SQLite3Engine extends DatabaseEngine
{
    /**
     * The database connection.
     *
     * @var \SQLite3
     */
    private $sqlite3;

    /**
     * A cache of the prepared statements, indexed by query.
     *
     * @var \SQLite3Stmt[]
     */
    private $statements = [];

    /**
     * @param \SQLite3 $sqlite3
     */
    public function __construct(\SQLite3 $sqlite3)
    {
        $this->sqlite3 = $sqlite3;
    }

    /**
     * @return \SQLite3
     */
    public function getSQLite3() : \SQLite3
    {
        return $this->sqlite3;
    }

    /**
     * {@inheritdoc}
     */
    protected function executeQuery(string $query, iterable $parameters) : iterable
    {
        if (isset($this->statements[$query])) {
            $statement = $this->statements[$query];
            $statement->reset();
        } else {
            // Temporary set the error reporting level to 0 to avoid any warning.
            $errorReportingLevel = error_reporting(0);

            $statement = $this->sqlite3->prepare($query);

            // Restore the original error reporting level.
            error_reporting($errorReportingLevel);

            $errorCode = $this->sqlite3->lastErrorCode();

            if ($errorCode !== 0) {
                $exception = new SQLite3Exception($this->sqlite3->lastErrorMsg(), $errorCode);

                if ($errorCode === 1) {
                    // SQL error cause by a missing function, this must be reported with a GeometryEngineException.
                    throw GeometryEngineException::operationNotSupportedByEngine($exception);
                }
                // Other SQLite3 error; we cannot trigger the original E_WARNING, so we throw this exception instead.
                throw $exception;
            }
            $this->statements[$query] = $statement;
        }

        $index = 1;

        foreach ($parameters as $parameter) {
            if ($parameter instanceof Geometry) {
                if ($parameter->isEmpty()) {
                    $statement->bindValue($index++, $parameter->asText(), SQLITE3_TEXT);
                    $statement->bindValue($index++, $parameter->SRID(), SQLITE3_INTEGER);
                } else {
                    $statement->bindValue($index++, $parameter->asBinary(), SQLITE3_BLOB);
                    $statement->bindValue($index++, $parameter->SRID(), SQLITE3_INTEGER);
                }
            } else {
                if ($parameter === null) {
                    $type = SQLITE3_NULL;
                } elseif (is_int($parameter)) {
                    $type = SQLITE3_INTEGER;
                } elseif (is_float($parameter)) {
                    $type = SQLITE3_FLOAT;
                } else {
                    $type = SQLITE3_TEXT;
                }

                $statement->bindValue($index++, $parameter, $type);
            }
        }

        $result = $statement->execute();

        return $result->fetchArray(SQLITE3_NUM);
    }
}
