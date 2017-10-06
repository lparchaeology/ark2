<?php

/**
 * ARK Database Connection.
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

use Doctrine\DBAL\Connection as DBALConnection;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class Connection extends DBALConnection {
    public function platform(): AbstractPlatform
    {
        return $this->getDriver ()->getDatabasePlatform ();
    }
    public function config(): iterable
    {
        return $this->getParams ();
    }
    public function generateGuid(): string
    {
        $sql = 'SELECT ?';
        $params = [
                $this->platform ()->getGuidExpression ()
        ];

        return $this->query ( $sql, $params )->fetchColumn ( 0 );
    }
    public function countRows(string $table): int
    {
        return $this->executeQuery ( "SELECT COUNT(*) FROM $table" )->fetch () ['COUNT(*)'];
    }
    public function fetchAllTable(string $table): iterable
    {
        return $this->fetchAll ( "SELECT * FROM $table" );
    }
    public function fetchAllColumn(string $sql, string $column, iterable $params = [], iterable $types = []): iterable
    {
        $rows = $this->executeQuery ( $sql, $params, $types )->fetchAll ();

        return array_column ( $rows, $column );
    }
    public function insertRows(string $table, iterable $fields, iterable $rows): void
    {
        $cols = count ( $fields );
        $fl = implode ( ', ', $fields );
        $vl = str_repeat ( '?, ', $cols - 1 ) . '?';
        $sql = "
            INSERT INTO $table ($fl)
            VALUES ($vl)
        ";
        $values = array_values ( array_shift ( $rows ) );
        foreach ( $rows as $row ) {
            $values = array_merge ( $values, array_values ( $row ) );
            $sql .= "
                , ($vl)
            ";
        }
        $this->executeUpdate ( $sql, $values );
    }
    public function generateSequence(string $module, string $parent, string $sequence): int
    {
        $this->beginTransaction ();
        // Check if there are any IDs to recycle first
        $sql = '
            SELECT *
            FROM ark_sequence_lock
            WHERE module = :module
            AND parent = :parent
            AND sequence = :sequence
            AND recycle = :recycle
        ' . $this->platform ()->getWriteLockSQL ();
        $params = [
                'module' => $module,
                'parent' => $parent,
                'sequence' => $sequence,
                'recycle' => true
        ];
        $recycle = $this->fetchAssoc ( $sql, $params );
        if ($recycle && $recycle ['recycle']) {
            try {
                // If there is one, try to recycle it
                $sql = '
                    UPDATE ark_sequence_lock
                    SET recycle = :recycle
                    WHERE id = :id
                ';
                $reparams = [
                        'recycle' => false,
                        'id' => $recycle ['id']
                ];
                $this->executeUpdate ( $sql, $reparams );
                $this->commit ();

                return $recycle ['idx'];
            } catch ( Exception $e ) {
                // If recycle fails, just try issue the next one
                $this->rollback ();
                $this->startTransaction ();
            }
        }
        $sql = '
            SELECT *
            FROM ark_sequence
            WHERE module = :module
            AND parent = :parent
            AND sequence = :sequence
        ' . $this->platform ()->getWriteLockSQL ();
        unset ( $params ['recycle'] );
        $seq = $this->fetchAssoc ( $sql, $params );
        if (! $seq) {
            // No sequence exists, so try create one
            try {
                $fields = [
                        'module',
                        'parent',
                        'sequence',
                        'idx'
                ];
                $rows = [
                        [
                                $module,
                                $parent,
                                $sequence,
                                1
                        ]
                ];
                $this->insertRows ( 'ark_sequence', $fields, $rows );
                $this->insertRows ( 'ark_sequence_lock', $fields, $rows );
                $this->commit ();

                return 1;
            } catch ( Exception $e ) {
                $this->rollback ();
                throw new ErrorException ( new InternalServerError ( 'DB_SEQUENCE_CREATE', 'Creating index sequence failed', "Creating the index sequence for Module $module Parent $parent Sequence $sequence failed" ) );
            }
        }
        if ($seq ['max'] && $seq ['idx'] >= $seq ['max']) {
            throw new ErrorException ( new InternalServerError ( 'DB_SEQUENCE_EXHASTED', 'Index sequence exhausted', "The index sequence for Module $module Parent $parent Sequence $sequence has reached maximum" ) );
        }
        try {
            $sql = '
                UPDATE ark_sequence
                SET idx = idx + 1
                WHERE module = :module
                AND parent = :parent
                AND sequence = :sequence
            ';
            $this->executeUpdate ( $sql, $params );
            $fields = [
                    'module',
                    'parent',
                    'sequence',
                    'idx'
            ];
            $rows = [
                    [
                            $module,
                            $parent,
                            $sequence,
                            1
                    ]
            ];
            $this->insertRows ( 'ark_sequence_lock', $fields, $rows );
            $this->commit ();

            return $seq ['idx'] + 1;
        } catch ( Exception $e ) {
            $this->data ()->rollback ();
            throw new ErrorException ( new InternalServerError ( 'DB_SEQUENCE_INCREMENT', 'Increment index sequence failed', "Incrementing the index sequence failed for Module $module Parent $parent Sequence $sequence" ) );
        }
    }
}
