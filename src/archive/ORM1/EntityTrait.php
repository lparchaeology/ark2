<?php

/**
 * ARK Entity Persister Interface
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

namespace ARK\ORM;

trait EntityTrait
{
    protected $modified = [];
    protected $createdOn = null;
    protected $createdBy = null;
    protected $lastModifiedBy = null;
    protected $lastModifiedOn = null;
    protected $version = null;

    public function isEntityModified()
    {
        return (count($this->modified) > 0);
    }

    public function isPropertyModified($property)
    {
        return (isset($this->modified[$property]));
    }

    protected function registerModified($property, $oldValue, $newValue)
    {
        if ($newValue === $oldValue) {
            return;
        }
        if (!$this->isEntityModified()) {
            $this->em->update($this);
        }
        $this->modified[$property] = [$oldValue, $newValue];
    }

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
}
