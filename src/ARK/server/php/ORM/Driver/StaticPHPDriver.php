<?php

/**
 * ARK ORM Unit of Work.
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

namespace ARK\ORM\Driver;

use ARK\Utility\ReflectionTrait;
use Doctrine\Common\Persistence\Mapping\Driver\StaticPHPDriver as DoctrinePhpDriver;
use Doctrine\Common\Persistence\Mapping\MappingException;
use Gedmo\Mapping\Driver;

class StaticPHPDriver extends DoctrinePhpDriver implements Driver
{
    use ReflectionTrait;

    /**
     * Modifed version of Doctrine\Common\Persistence\Mapping\Driver\StaticPHPDriver.
     * @author Benjamin Eberlei <kontakt@beberlei.de>
     * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
     * @author Jonathan H. Wage <jonwage@gmail.com>
     * @author Roman Borschel <roman@code-factory.org>
     */
    public function getAllClassNames() : iterable
    {
        $classNames = $this->reflectGetValue('classNames');
        $paths = $this->reflectGetValue('paths');

        if ($classNames !== null) {
            return $classNames;
        }

        if (!$paths) {
            throw MappingException::pathRequired();
        }

        $classNames = [];
        $includedFiles = [];
        foreach ($paths as $path) {
            if (is_dir($path)) {
                $iterator = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($path),
                    \RecursiveIteratorIterator::LEAVES_ONLY
                );

                foreach ($iterator as $file) {
                    if ($file->getBasename('.php') === $file->getBasename()) {
                        continue;
                    }

                    $sourceFile = realpath($file->getPathName());
                    require_once $sourceFile;
                    $includedFiles[] = $sourceFile;
                }
            } else {
                $sourceFile = realpath($path);
                require_once $sourceFile;
                $includedFiles[] = $sourceFile;
            }
        }

        $declared = get_declared_classes();

        foreach ($declared as $className) {
            $rc = new \ReflectionClass($className);
            $sourceFile = $rc->getFileName();
            if (in_array($sourceFile, $includedFiles, true) && !$this->isTransient($className)) {
                $classNames[] = $className;
            }
        }

        $this->reflectSetValue('classNames', $classNames);

        return $classNames;
    }

    public function readExtendedMetadata($meta, iterable &$config) : void
    {
        if ($meta->getReflectionClass()->hasMethod('readExtendedMetadata')) {
            $className = $meta->name;
            $className::readExtendedMetadata($config);
        }
    }

    public function setOriginalDriver($driver) : void
    {
    }
}
