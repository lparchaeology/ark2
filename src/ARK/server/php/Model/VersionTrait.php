<?php

/**
 * ARK Model Version Trait.
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

namespace ARK\Model;

use ARK\Actor\Actor;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Service;
use DateTime;

trait VersionTrait
{
    protected $creator;
    protected $created;
    protected $modifier;
    protected $modified;
    protected $version = '';

    public function created() : DateTime
    {
        return $this->created;
    }

    public function creator() : Actor
    {
        return $this->creator;
    }

    public function lastModified() : DateTime
    {
        return $this->modified;
    }

    public function lastModifier() : Actor
    {
        return $this->modifier;
    }

    public function version() : string
    {
        return $this->version;
    }

    public function refreshVersion(Actor $creator = null, DateTime $created = null) : void
    {
        if ($creator) {
            $this->creator = $creator;
            $this->created = $created;
        }
        $actor = Service::workflow()->actor();
        $this->modifier = $actor;
        $this->modified = new DateTime();
        if (!$this->creator || !$this->created) {
            $this->creator = $this->modifier;
            $this->created = $this->modified;
        }
    }

    public static function buildVersionMetadata(ClassMetadataBuilder $builder) : void
    {
        $builder->addManyToOneField('modifier', Actor::class, 'modifier', 'id', true);
        $builder->addField('modified', 'datetime');
        $builder->addManyToOneField('creator', Actor::class, 'creator', 'id', true);
        $builder->addField('created', 'datetime');
        $builder->addStringField('version', 128);
    }
}
