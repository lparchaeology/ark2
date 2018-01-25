<?php

/**
 * ARK File Entity.
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

namespace ARK\File;

use ARK\Model\Item;
use ARK\Model\ItemTrait;
use ARK\ORM\ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class File implements Item
{
    use ItemTrait;
    protected $versions;
    protected $current;

    protected function __construct(string $schema = 'core.file')
    {
        $this->construct($schema);
    }

    public function path() : string
    {
        return $this->current()->path();
    }

    public function name() : string
    {
        return $this->current()->name();
    }

    public function extension() : string
    {
        return $this->current()->extension();
    }

    public function title() : string
    {
        return $this->value('title');
    }

    public function description() : string
    {
        return $this->value('description');
    }

    public function version()
    {
        return $this->current()->version();
    }

    public function current() : ?FileVersion
    {
        if ($this->current === null) {
            $seq = -1;
            foreach ($this->versions() as $version) {
                if ($version->sequence() > $seq) {
                    $this->current = $version;
                }
            }
        }
        return $this->current;
    }

    public function addFileVersion(
        string $name,
        string $extension,
        string $version = null,
        DateTime $created = null
    ) : void {
        $this->current();
        $this->current = FileVersion::create(
            $this->id(),
            $this->mediatype()->type(),
            $name,
            $extension,
            $version,
            $created
        );
        $this->versions[] = $this->current;
        $this->setValue('versions', $this->versions);
    }

    public function versions() : iterable
    {
        if ($this->versions === null) {
            $this->versions = $this->value('versions');
        }
        return $this->versions;
    }

    public function status() : string
    {
        return $this->value('status');
    }

    public function license() : Term
    {
        return $this->value('license');
    }

    public function copyright() : string
    {
        return $this->value('copyright');
    }

    public function mediatype() : MediaType
    {
        if ($this->mediatype === null) {
            $this->mediatype = new MediaType($this->value('mediatype'));
        }
        return $this->mediatype;
    }

    public static function createFromUploadedFile(UploadedFile $upload) : ?self
    {
        if ($upload->isValid()) {
            $file = self::createForMediatype($upload->getMimetype());
            $file->addFileVersion($upload->getClientOriginalName(), $upload->getClientOriginalExtension());
            $stream = fopen($upload->getRealPath(), 'r+');
            $file->current()->writeStream($stream);
            fclose($stream);
            return $file;
        }
        return null;
    }

    public static function createFromContent(MediaType $mediatype, string $filename, $content) : self
    {
        $file = self::createForMediatype($mediatype);
        $file->addFileVersion($filename, $mediatype->defaultExtension());
        $file->current()->write($content);
        return $file;
    }

    protected function setMediatype(MediaType $mediatype) : void
    {
        $this->mediatype = $mediatype;
        $this->setValue('mediatype', $mediatype->mediatype());
    }

    protected static function createForMediatype($mediatype) : self
    {
        if (is_string($mediatype)) {
            $mediatype = new MediaType($mediatype);
        }
        if (!$mediatype instanceof MediaType) {
            return new Other();
        }
        switch ($mediatype->type()) {
            case 'audio':
                $file = new Audio();
                break;
            case 'document':
                $file = new Document();
                break;
            case 'image':
                $file = new Image();
                break;
            case 'text':
                $file = new Text();
                break;
            case 'video':
                $file = new Video();
                break;
            default:
                $file = new Other();
                break;
        }
        $file->setMediatype($mediatype);
        ORM::persist($file);
        return $file;
    }
}
