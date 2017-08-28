<?php

/**
 * ARK ORM Unit of Work.
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

namespace ARK\ORM\Driver;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriver;
use Doctrine\Common\Persistence\Mapping\MappingException;
use Gedmo\Mapping\Driver;

/**
 * The StaticPHPDriver calls a static loadMetadata() method on your entity
 * classes where you can manually populate the ClassMetadata instance.
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author Jonathan H. Wage <jonwage@gmail.com>
 * @author Roman Borschel <roman@code-factory.org>
 */
class StaticPHPDriver implements MappingDriver, Driver
{
    private $paths = [];
    private $classNames;

    public function __construct($paths)
    {
        $this->addPaths((array) $paths);
    }

    public function addPaths(iterable $paths) : void
    {
        $this->paths = array_unique(array_merge($this->paths, $paths));
    }

    public function loadMetadataForClass($className, ClassMetadata $metadata) : void
    {
        $className::loadMetadata($metadata);
    }

    public function readExtendedMetadata($meta, iterable &$config) : void
    {
        if ($meta->getReflectionClass()->hasMethod('readExtendedMetadata')) {
            $className = $meta->name;
            $className::readExtendedMetadata($config);
        }
    }

    public function getAllClassNames() : iterable
    {
        if ($this->classNames !== null) {
            return $this->classNames;
        }

        if (!$this->paths) {
            throw MappingException::pathRequired();
        }

        $classes = [];
        $includedFiles = [];
        foreach ($this->paths as $path) {
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
                $classes[] = $className;
            }
        }

        $this->classNames = $classes;

        return $classes;
    }

    public function isTransient($className) : bool
    {
        return !method_exists($className, 'loadMetadata');
    }

    public function setOriginalDriver($driver) : void
    {
    }
}
