<?php

/**
 * ARK File Version.
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

use ARK\ARK;
use ARK\Security\User;
use ARK\Service;
use DateTime;
use League\Flysystem\File as FileHandler;

class FileVersion extends FileHandler
{
    protected $name = '';
    protected $path = '';
    protected $extension = '';
    protected $sequence = 0;
    protected $version = '';
    protected $created;
    protected $creator;
    protected $modified;
    protected $modifier;
    protected $expires;

    public function __construct()
    {
        parent::__construct(Service::filesystem());
    }

    public function path() : string
    {
        return $this->path;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function extension() : string
    {
        return $this->extension;
    }

    public function sequence() : int
    {
        return $this->sequence;
    }

    public function version() : string
    {
        return $this->version;
    }

    public function created() : DateTime
    {
        return $this->created;
    }

    public function creator() : string
    {
        return $this->creator;
    }

    public function modified() : DateTime
    {
        return $this->modified;
    }

    public function modifier() : string
    {
        return $this->modifier;
    }

    public function setModified(DateTime $modified = null, User $modifier = null) : void
    {
        $this->modified = ($modified ?: ARK::timestamp());
        $this->modifier = ($modifier ? $modifier : Service::security()->user()->id());
    }

    public function expires() : ?DateTime
    {
        return $this->expires;
    }

    public function setExpiry(DateTime $expiresOn) : void
    {
        $this->expires = $expiresOn;
    }

    public static function makeFilePath(string $type, int $id, int $sequence, string $extension) : string
    {
        $token = intdiv($id, 1000) * 1000;
        return "$type/$token/$id.$sequence.$extension";
    }

    public static function create(
        string $id,
        string $type,
        string $name,
        string $extension,
        string $version = null,
        DateTime $created = null
    ) : FileVersion {
        $file = new self();
        $file->name = $name;
        $file->extension = $extension;
        if (!$created) {
            $created = ARK::timestamp();
        }
        $file->sequence = $created->format('YmdHis');
        $file->path = self::makeFilePath($type, $id, $file->sequence, $extension);
        $file->version = ($version ? $version : $created->format('Y-m-d H:i:s'));
        $file->created = $created;
        $file->creator = Service::security()->user()->id();
        $file->modified = $created;
        $file->modifier = $file->creator;
        return $file;
    }

    // TODO Do this in ObjectFormat? Use magic methods?
    public static function fromArray(array $data) : FileVersion
    {
        $file = new self();
        $file->name = $data['name'] ?? '';
        $file->path = $data['path'] ?? '';
        $file->extension = $data['extension'] ?? '';
        $file->sequence = $data['sequence'] ?? 0;
        $file->version = $data['version'] ?? '';
        $file->created = $data['created'] ?? null;
        $file->creator = $data['creator'] ?? '';
        $file->modified = $data['modified'] ?? $file->created;
        $file->modifier = $data['modifier'] ?? $file->creator;
        $file->expires = $data['expires'] ?? null;
        return $file;
    }

    // TODO Do this in ObjectFormat? Use magic methods?
    public static function toArray(FileVersion $file) : iterable
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
