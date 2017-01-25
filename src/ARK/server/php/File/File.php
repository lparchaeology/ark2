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
 * @copyright  2017 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\File;

use ARK\File\FileVersion;
use ARK\Model\Item;
use ARK\Model\ItemTrait;
use ARK\ORM\ClassMetadata;

class File implements Item
{
    use ItemTrait;

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

    public function originalName()
    {
        return $this->currentVersion()->sequence();
    }

    public function mediatype()
    {
        return $this->type()->name();
    }

    public function versions()
    {
        if (!$this->versions) {
            foreach ($this->properties('versions') as $version) {
                $file = FileVersion::fromProperty($this);
                $this->versions[$file->sequence] = $file;
            }
            if (!$this->versions) {
                $this->versions[0] = new FileVersion($this);
            }
        }
        return $this->versions;
    }

    public function version($sequence = null)
    {
        if ($sequence = null) {
            return end($this->versions());
        }
    }

    public function mimetype()
    {
        if (!$this->mimetype) {
            $this->mimetype = new MimeType($this->currentVersion()->getMimeType());
        }
        return $this->mimetype;
    }

    public function storagePath()
    {
        return $this->currentVersion()->storagePath();
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        ItemTrait::buildItemMetadata($metadata, 'file');
    }
}
