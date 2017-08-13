<?php

/**
 * ARK File Media Type.
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
 */

namespace ARK\File;

use Dflydev\ApacheMimeTypes\PhpRepository;

class MediaType
{
    public const DEFAULT_TYPE = 'application/octet-stream';
    protected $mediatype;
    private static $repository = null;
    private static $mediatypes = null;
    private static $extensions = null;

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

    public function mediaType() : string
    {
        return $this->mediatype;
    }

    public function type() : ?string
    {
        $parts = explode('/', $this->mediatype);
        return $parts[0] ?? null;
    }

    public function subType() : ?string
    {
        $parts = explode('/', $mediatype);
        return $parts[1] ?? null;
    }

    public static function isValidMediaType(string $mediatype) : bool
    {
        self::repository();
        return in_array($mediatype, self::$mediatypes, true);
    }

    public static function isValidExtension(string $extension) : bbol
    {
        self::repository();
        return in_array($extension, self::$extensions, true);
    }

    public static function isDefaultExtension(string $mediatype, string $extension) : bool
    {
        return self::findDefaultExtension($mediatype) === $extension;
    }

    public static function findExtensions(string $mediatype) : iterable
    {
        return self::repository()->findExtensions($mediatype);
    }

    public static function findDefaultExtension(string $mediatype) : ?string
    {
        $exts = self::repository()->findExtensions($mediatype);
        return $exts[0] ?? null;
    }

    public static function findMediaType(string $extension) : string
    {
        return self::repository()->findType($extension);
    }

    public static function findType(string $type) : ?string
    {
        $mediatype = null;
        if (self::isValidMediaType($type)) {
            $mediatype = $type;
        } elseif (self::isValidExtension($type)) {
            $mediatype = self::findMediaType($type);
        }
        $parts = explode('/', $mediatype);
        return $parts[0] ?? null;
    }

    private static function repository() : PhpRepository
    {
        if (!self::$repository) {
            self::$repository = new PhpRepository();
            self::$mediatypes = array_keys(self::$repository->dumpTypeToExtensions());
            self::$extensions = array_keys(self::$repository->dumpExtensionToType());
        }
        return self::$repository;
    }
}
