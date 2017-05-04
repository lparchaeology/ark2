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
use League\Flysystem\File as FileHandler;
use League\Flysystem\FilesystemInterface;

class FileVersion extends FileHandler
{
    protected $file = null;
    protected $path = null;
    protected $sequence = null;
    protected $name = null;
    protected $version = null;
    protected $createdOn = null;
    protected $createdBy = null;
    protected $modifiedOn = null;
    protected $modifiedBy = null;
    protected $expires = null;

    public function __construct(File $file, DateTime $created = null, $version = null)
    {
        $this->file = $file;
        $this->suffix = $file->suffix();
        //TODO Check is UTC!
        if (!$created) {
            $created = ARK::timestamp();
        }
        $this->created = $created;
        $this->modified = $created;
        $this->version = ($version ? $version : $created->format('YmdHis'));
        $filepath = Service::filesystem()->dataPath().'/'.$file->mediaPath().'.'.$this->version.$file->suffix();
        parent::__construct(Service::filesystem(), $filepath);
    }

    public function originalName()
    {
        return $this->name;
    }

    public function sequence()
    {
        return $this->sequence;
    }

    public function name()
    {
        return $this->version;
    }

    public function createdOn()
    {
        return $this->createdOn;
    }

    public function createdBy()
    {
        return $this->createdBy;
    }

    public function modifiedOn()
    {
        return $this->modifiedOn;
    }

    public function modifiedBy()
    {
        return $this->modifiedBy;
    }

    public function setModified(DateTime $modifiedOn, $modifiedBy)
    {
        $this->modifiedOn = $modifiedOn;
        $this->modifiedBy = $modifiedBy;
    }

    public function expiresOn()
    {
        return $this->expires;
    }

    public function setExpiry(DateTime $expiresOn)
    {
        $this->expires = $expiresOn;
    }

    private function makePath()
    {
        $id = (int) $this->file->id();
        $mod = $id - ($id % 1000);
        $this->path = $this->file->mediatype()."/$mod/$id/$id.".$this->sequence.'.'.$this->suffix;
    }

    public static function fromProperty(Property $property)
    {
        $version = new FileVersion();
        $version->file = $property->item();
        $config = $property->serialize();
        $version->sequence = $config['sequence'];
        $version->name = $config['name'];
        $version->version = $config['version'];
        $version->createdOn = $config['created']['on'];
        $version->createdBy = $config['created']['by'];
        $version->modifiedOn = $config['modified']['on'];
        $version->modifiedBy = $config['modified']['by'];
        $version->expires = $config['expires'];
        $version->makePath();
        return $version;
    }
}
