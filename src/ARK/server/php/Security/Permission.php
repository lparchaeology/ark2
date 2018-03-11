<?php

/**
 * ARK Security Permission.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
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
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Security;

use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use Doctrine\Common\Collections\ArrayCollection;

class Permission
{
    use KeywordTrait;

    public const GRANT = true;
    public const DENY = false;
    public const ABSTAIN = null;

    protected $permission = '';
    protected $enabled = true;
    protected $roles;

    public function __construct(string $permission)
    {
        $this->permission = $permission;
        $this->roles = new ArrayCollection();
    }

    public function id() : string
    {
        return $this->permission;
    }

    public function isEnabled() : bool
    {
        return $this->enabled;
    }

    public static function find(string $id) : ? self
    {
        return ORM::find(self::class, $id);
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_security_permission');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('permission', 30);

        // Attributes
        $builder->addField('enabled', 'boolean');
        KeywordTrait::buildKeywordMetadata($builder);

        // Relationships
        $builder->addManyToManyField('roles', Role::class, 'ark_security_grant', 'permission', 'role');
    }
}
