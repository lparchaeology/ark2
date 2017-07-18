<?php

/**
 * ARK File Media Type
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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\File;

use Dflydev\ApacheMimeTypes\PhpRepository;

class MediaType
{
    const DEFAULT_TYPE = 'application/octet-stream';
    private static $repository = null;
    private static $mediatypes = null;
    private static $extensions = null;
    protected $mediatype = null;

    public function __construct(string $type = self::DEFAULT_TYPE)
    {
        if (self::isValidMediaType($type)) {
            $this->mediatype = $type;
        } elseif (self::isValidExtension($type)) {
            $this->mediatype = self::findType($type);
        } else {
            $this->mediatype = self::DEFAULT_TYPE;
        }
    }

    public function mediaType()
    {
        return $this->mediatype;
    }

    public function type()
    {
        $parts = explode('/', $this->mediatype);
        return isset($parts[0]) ? $parts[0] : null;
    }

    public function subType()
    {
        $parts = explode('/', $mediatype);
        return isset($parts[1]) ? $parts[1] : null;
    }

    private static function repository()
    {
        if (!self::$repository) {
            self::$repository = new PhpRepository();
            self::$mediatypes = array_keys(self::$repository->dumpTypeToExtensions());
            self::$extensions = array_keys(self::$repository->dumpExtensionToType());
        }
        return self::$repository;
    }

    public static function isValidMediaType(string $mediatype)
    {
        self::repository();
        return in_array($mediatype, self::$mediatypes);
    }

    public static function isValidExtension(string $extension)
    {
        self::repository();
        return in_array($extension, self::$extensions);
    }

    public static function isDefaultExtension(string $mediatype, string $extension)
    {
        return (self::findDefaultExtension($mediatype) === $extension);
    }

    public static function findExtensions(string $mediatype)
    {
        return self::repository()->findExtensions($mediatype);
    }

    public static function findDefaultExtension(string $mediatype)
    {
        $exts = self::repository()->findExtensions($mediatype);
        return isset($exts[0]) ? $exts[0] : null;
    }

    public static function findMediaType(string $extension)
    {
        return self::repository()->findType($extension);
    }

    public static function findType(string $type)
    {
        $mediatype = null;
        if (self::isValidMediaType($type)) {
            $mediatype = $type;
        } elseif (self::isValidExtension($type)) {
            $mediatype = self::findMediaType($type);
        }
        $parts = explode('/', $mediatype);
        return isset($parts[0]) ? $parts[0] : null;
    }
}
