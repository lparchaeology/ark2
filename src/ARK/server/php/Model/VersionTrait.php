<?php

/**
 * ARK Model Version Trait
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

namespace ARK\Model;

use ARK\ORM\ClassMetadataBuilder;

trait VersionTrait
{
    protected $createdOn = null;
    protected $createdBy = null;
    protected $lastModifiedBy = null;
    protected $lastModifiedOn = null;
    protected $version = '';

    public function createdOn()
    {
        return $this->createdOn;
    }

    public function createdBy()
    {
        return $this->createdBy;
    }

    public function lastModifiedOn()
    {
        return $this->lastModifiedOn;
    }

    public function lastModifiedBy()
    {
        return $this->lastModifiedBy;
    }

    public function version()
    {
        return $this->version;
    }

    public function refreshVersion()
    {
        // TODO Auto-update behaviour
        //$user = Service::user();
        if (!$this->createdBy || !$this->createdOn) {
            $this->createdBy = 0;//$user->id();
            $this->createdOn = new \DateTime;
        }
        $this->lastModifiedBy = 0;//$user->id();
        $this->lastModifiedOn = new \DateTime;
    }

    public static function buildVersionMetadata(ClassMetadataBuilder $builder)
    {
        $builder->addField('lastModifiedBy', 'integer', [], 'mod_by');
        $builder->addField('lastModifiedOn', 'datetime', [], 'mod_on');
        $builder->addField('createdBy', 'integer', [], 'cre_by');
        $builder->addField('createdOn', 'datetime', [], 'cre_on');
        $builder->addStringField('version', 128);
    }
}
