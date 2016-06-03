<?php

/**
 * ARK File Version
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

use ARK\Service;
use DateTime;
use DateTimeZone;
use League\Flysystem\File as FileHandler;
use League\Flysystem\FilesystemInterface;

class FileVersion extends FileHandler
{
    private $file = null;
    private $version = null;
    private $created = null;
    private $modified = null;
    private $expires = null;

    public function __construct(File $file, DateTime $created = null, $version = null)
    {
        $this->file = $file->id();
        $this->suffix = $file->suffix();
        //TODO Check is UTC!
        if (!$created) {
            $created = new DateTime(null, new DateTimeZone("UTC"));
        }
        $this->created = $created;
        $this->modified = $created;
        if (!$version) {
            $version = $created->format('YmdHis');
        }
        $this->version = $version;
        $filepath = Service::filesystem()->dataPath().'/'.$file->mediaPath().'.'.$this->version.$file->suffix();
        parent::__construct(Service::filesystem(), $filepath);
    }

    public function version()
    {
        return $this->version;
    }

    public function created()
    {
        return $this->created;
    }

    public function modified()
    {
        return $this->modified;
    }

    public function setModified(DateTime $modifiedAt, $modifiedBy)
    {
        $this->modified = $modified;
    }

    public function expires()
    {
        return $this->expires;
    }

    public function setExpiry(DateTime $expiresAt)
    {
        $this->expires = $expiresAt;
    }
}
