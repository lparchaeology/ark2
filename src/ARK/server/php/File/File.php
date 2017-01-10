<?php

/**
 * ARK File Item
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

use ARK\File\FileVersion;
use ARK\Model\Item;
use ARK\ORM\ClassMetadata;

class File extends Item
{
    const NEW_FILE = 0;
    const CHECKED_IN = 1;
    const CHECKED_OUT = 2;
    const LOCKED = 3;
    const EXPIRED = 4;
    protected $status = File::NEW_FILE;
    protected $mimetype = null;
    protected $versions = null;

    public function __construct($path)
    {
        $this->versions[] = new FileVersion(Service::filesystem(), $path);
    }

    public function mediatype()
    {
        return $this->subtype()->name();
    }

    public function versions()
    {
        if (!$this->versions) {
            $this->versions[] = new FileVersion(Service::filesystem(), $path);
        }
        return $this->versions;
    }

    public function currentVersion()
    {
        return end($this->versions());
    }

    public function mimetype()
    {
        if (!$this->mimetype) {
            $this->mimetype = new MimeType($this->currentVersion()->getMimeType());
        }
        return $this->mimetype;
    }

    public function filepath()
    {
        return $this->currentVersion()->path();
    }

    public function size()
    {
        return $this->currentVersion()->getSize();
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $metadata->setTableName('ark_item_file');
        $metadata->setItemEntity(true);
        $builder->setSingleTableInheritance()->setDiscriminatorColumn('subtype', 'string', 30);
        $builder->addDiscriminatorMapClass('audio', 'ARK\\File\\Audio');
        $builder->addDiscriminatorMapClass('document', 'ARK\\File\\Document');
        $builder->addDiscriminatorMapClass('image', 'ARK\\File\\Image');
        $builder->addDiscriminatorMapClass('other', 'ARK\\File\\File');
        $builder->addDiscriminatorMapClass('text', 'ARK\\File\\Text');
        $builder->addDiscriminatorMapClass('video', 'ARK\\File\\Video');
    }
}
