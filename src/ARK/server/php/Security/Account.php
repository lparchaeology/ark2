<?php

/**
 * ARK User Account
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

namespace ARK\Security;

use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use Doctrine\ORM\Mapping\ClassMetadata;

class Account
{
    protected $user;
    protected $account;
    protected $protocol;
    protected $provider;
    protected $identifier;
    protected $accessToken;
    protected $refreshToken;

    public function __construct($user, $account)
    {
        $this->user = $user;
        $this->account = $account;
    }

    public function id()
    {
        return ['user' => $user->id(), 'account' => $this->account];
    }

    public function user()
    {
        return $this->user;
    }

    public function account()
    {
        return $this->account;
    }

    public function protocol()
    {
        return $this->protocol;
    }

    public function provider()
    {
        return $this->provider;
    }

    public function identifier()
    {
        return $this->identifier;
    }

    public function accessToken()
    {
        return $this->accessToken;
    }

    public function refreshToken()
    {
        return $this->refreshToken;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_security_account');

        // Key
        $builder->addManyToOneKey('user', User::class);
        $builder->addStringKey('account', 30);

        // Attributes
        $builder->addStringField('protocol', 30);
        $builder->addStringField('provider', 30);
        $builder->addStringField('identifier', 30);
        $builder->addStringField('accessToken', 30, 'access_token');
        $builder->addStringField('refresh_token', 30, 'refresh_token');
        $builder->addField('enabled', 'boolean');
    }
}
