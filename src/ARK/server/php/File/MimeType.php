<?php

/**
 * ARK File Mime Type
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

class MimeType
{
    const DEFAULT_TYPE = 'application/octet-stream';
    private static $repository = null;
    private static $mimetypes = null;
    private static $extensions = null;
    private $mimetype = null;

    public function __construct(/*string*/ $type = DEFAULT_TYPE)
    {
        if (self::isValidMimeType($type)) {
            $this->mimetype = $type;
        } elseif (self::isValidExtension($type)) {
            $this->mimetype = self::findType($type);
        }
        $this->mimetype = DEFAULT_TYPE;
    }

    public function mimeType()
    {
        return self::parseMediaType($this->mimetype);
    }

    public function mediaType()
    {
        return self::parseMediaType($this->mimetype);
    }

    private static function parseMediaType($mimetype)
    {
        $parts = explode('/', $mimetype);
        return isset($parts[0]) ? $parts[0] : null;
    }

    private static function repository()
    {
        if (!self::$repository) {
            self::$repository = new PhpRepository();
            self::$mimetypes = array_keys(self::$repository->dumpTypeToExtensions());
            self::$extensions = array_keys(self::$repository->dumpExtensionToType());
        }
        return self::$repository;
    }

    public static function isValidMimeType($mimetype)
    {
        self::repository();
        return in_array($mimetype, self::$mimetypes);
    }

    public static function isValidExtension($extension)
    {
        self::repository();
        return in_array($extension, self::$extensions);
    }

    public static function isDefaultExtension($mimetype, $extension)
    {
        return (self::findDefaultExtension($mimetype) === $extension);
    }

    public static function findExtensions($mimetype)
    {
        return self::repository()->findExtensions($mimetype);
    }

    public static function findDefaultExtension($mimetype)
    {
        $exts = self::repository()->findExtensions($mimetype);
        return isset($exts[0]) ? $exts[0] : null;
    }

    public static function findMimeType($extension)
    {
        return self::repository()->findType($extension);
    }

    public static function findMediaType($type)
    {
        if (self::isValidMimeType($type)) {
            return self::parseMediaType($type);
        } elseif (self::isValidExtension($type)) {
            return self::parseMediaType(self::findMimeType($type));
        }
        return null;
    }
}
