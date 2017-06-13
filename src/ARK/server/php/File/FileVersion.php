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

use ARK\ARK;
use ARK\Service;
use DateTime;
use ARK\Model\Property;
use ARK\Security\User;
use League\Flysystem\File as FileHandler;
use League\Flysystem\FilesystemInterface;

class FileVersion extends FileHandler
{
    protected $name = null;
    protected $extension = null;
    protected $sequence = null;
    protected $version = null;
    protected $created = null;
    protected $creator = null;
    protected $modified = null;
    protected $modifier = null;
    protected $expires = null;

    public function __construct()
    {
        parent::__construct(Service::filesystem());
    }

    public function path()
    {
        return $this->path;
    }

    public function name()
    {
        return $this->name;
    }

    public function extension()
    {
        return $this->extension;
    }

    public function sequence()
    {
        return $this->sequence;
    }

    public function version()
    {
        return $this->version;
    }

    public function created()
    {
        return $this->created;
    }

    public function creator()
    {
        return $this->creator;
    }

    public function modified()
    {
        return $this->modified;
    }

    public function modifier()
    {
        return $this->modifier;
    }

    public function setModified(DateTime $modified = null, User $modifier = null)
    {
        $this->modified = ($modified ?: ARK::timestamp());
        $this->modifier = ($modifier ? $modifier : Service::security()->user()->id());
    }

    public function expires()
    {
        return $this->expires;
    }

    public function setExpiry(DateTime $expiresOn)
    {
        $this->expires = $expiresOn;
    }

    public static function makeFilePath($type, $id, $sequence, $extension)
    {
        $token = floor(intval($id) / 1000) * 1000;
        return "$type/$token/$id.$sequence.$extension";
    }

    public static function create($id, $type, $name, $extension, $version = null, DateTime $created = null)
    {
        $file = new FileVersion;
        $file->name = $name;
        $file->extension = $extension;
        if (!$created) {
            $created = ARK::timestamp();
        }
        $file->sequence = $created->format('YmdHis');
        $file->path = FileVersion::makeFilePath($type, $id, $file->sequence, $extension);
        $file->version = ($version ? $version : $created->format('Y-m-d H:i:s'));
        $file->created = $created;
        dump(Service::security()->user());
        $file->creator = Service::security()->user()->id();
        $file->modified = $created;
        $file->modifier = $file->creator;
        return $file;
    }

    // TODO Do this in ObjectFormat? Use magic methods?
    public static function fromArray(array $data)
    {
        $file = new FileVersion();
        $file->path = isset($data['path']) ? $data['path'] : null;
        $file->name = isset($data['name']) ? $data['name'] : null;
        $file->extension = isset($data['extension']) ? $data['extension'] : null;
        $file->sequence = isset($data['sequence']) ? $data['sequence'] : null;
        $file->version = isset($data['version']) ? $data['version'] : null;
        $file->created = isset($data['created']) ? $data['created'] : null;
        $file->creator = isset($data['creator']) ? $data['creator'] : null;
        $file->modified = isset($data['modified']) ? $data['modified'] : null;
        $file->modifier = isset($data['modifier']) ? $data['modifier'] : null;
        $file->expires = isset($data['expires']) ? $data['expires'] : null;
        return $file;
    }

    // TODO Do this in ObjectFormat? Use magic methods?
    public static function toArray(FileVersion $file)
    {
        $data['path'] = $file->path();
        $data['name'] = $file->name();
        $data['extension'] = $file->extension();
        $data['sequence'] = $file->sequence();
        $data['version'] = $file->version();
        $data['created'] = $file->created();
        $data['creator'] = $file->creator();
        $data['modified'] = $file->modified();
        $data['modifier'] = $file->modifier();
        $data['expires'] = $file->expires();
        return $data;
    }
}
