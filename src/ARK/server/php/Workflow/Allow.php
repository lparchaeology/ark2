<?php

/**
 * ARK Workflow Action.
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

namespace ARK\Workflow;

use ARK\Actor\Actor;
use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;

class Allow
{
    use KeywordTrait;

    public const GRANT = true;
    public const DENY = false;
    public const ABSTAIN = null;

    protected $schma = '';
    protected $actionName = '';
    protected $action;
    protected $role;
    protected $operator = 'is';

    public function role() : Role
    {
        return $this->role;
    }

    public function isAllowed(Actor $actor) : bool
    {
        $hasRole = $this->role->hasActor($actor);
        if ($hasRole) {
            return $this->operator === 'not' ? self::DENY : self::GRANT;
        }
        return self::ABSTAIN;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_workflow_allow');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('schma', 30);
        $builder->addStringKey('actionName', 30, 'action');
        $builder->addManyToOneKey('role', Role::class);

        // Fields
        $builder->addStringField('operator', 10);

        // Associations
        $builder->addCompositeManyToOneField(
            'action',
            Action::class,
            [
                ['column' => 'schma', 'nullable' => true],
                ['column' => 'action', 'nullable' => true],
            ],
            'allowances'
        );
    }
}
