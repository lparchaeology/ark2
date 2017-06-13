<?php

/**
 * ARK Item Entity
 *
 * This file is automatically generated as part of ARK, the Archaeological Recording Kit.
 */

namespace ARK\File;

use ARK\File\MediaType;
use ARK\Model\Item;
use ARK\Model\ItemTrait;
use ARK\ORM\ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class File implements Item
{
    protected $versions = null;
    protected $current = null;

    use ItemTrait;

    protected function __construct($schema = 'core.file')
    {
        $this->construct($schema);
    }

    public function path()
    {
        return $this->current()->path();
    }

    public function name()
    {
        return $this->current()->name();
    }

    public function extension()
    {
        return $this->current()->extension();
    }

    public function title()
    {
        return $this->property('title')->value();
    }

    public function description()
    {
        return $this->property('description')->value();
    }

    public function version()
    {
        return $this->current()->version();
    }

    public function current()
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

    public function addFileVersion($name, $extension, $version = null, DateTime $created = null)
    {
        $this->current();
        $this->current = FileVersion::create($this->id(), $this->mediatype()->type(), $name, $extension, $version, $created);
        $this->versions[] = $this->current;
        $this->property('versions')->setValue($this->versions);
    }

    public function versions()
    {
        if ($this->versions === null) {
            $this->versions = $this->property('versions')->value();
            dump($this->versions);
        }
        return $this->versions;
    }

    public function status()
    {
        return $this->property('status')->value();
    }

    public function license()
    {
        return $this->property('license')->value();
    }

    public function copyright()
    {
        return $this->property('copyright')->value();
    }

    public function mediatype()
    {
        if ($this->mediatype === null) {
            $this->mediatype = new MediaType($this->property('mediatype')->value());
        }
        return $this->mediatype;
    }

    protected function setMediatype(MediaType $mediatype)
    {
        $this->mediatype = $mediatype;
        $this->property('mediatype')->setValue($mediatype->mediatype());
    }

    public static function createFromUploadedFile(UploadedFile $upload)
    {
        if ($upload->isValid()) {
            $file = File::createForMediatype($upload->getMimetype());
            $file->addFileVersion($upload->getClientOriginalName(), $upload->getClientOriginalExtension());
            $stream = fopen($upload->getRealPath(), 'r+');
            $file->current()->writeStream($stream);
            fclose($stream);
            return $file;
        }
        return null;
    }

    protected static function createForMediatype($mediatype)
    {
        if (is_string($mediatype)) {
            $mediatype = new MediaType($mediatype);
        }
        if (! $mediatype instanceof MediaType) {
            return new Other;
        }
        switch ($mediatype->type()) {
            case 'audio':
                $file = new Audio;
                break;
            case 'document':
                $file = new Document;
                break;
            case 'image':
                $file = new Image;
                break;
            case 'text':
                $file = new Text;
                break;
            case 'video':
                $file = new Video;
                break;
            default:
                $file = new Other;
                break;
        }
        $file->setMediatype($mediatype);
        ORM::persist($file);
        return $file;
    }
}
