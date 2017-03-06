<?php

/**
 * ARK Translation Domain Entity
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

namespace ARK\Translation;

use ARK\Service;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Translation\Message;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Common\Collections\ArrayCollection;

class Translation
{
    protected $keyword = '';
    protected $domain = null;
    protected $isPlural = false;
    protected $hasParameters = false;
    protected $parameters = null;
    protected $messages = null;

    public function __construct($keyword, Domain $domain)
    {
        $this->keyword = $keyword;
        $this->domain = $domain;
        $this->parameters = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function keyword()
    {
        return $this->keyword;
    }

    public function domain()
    {
        return $this->domain;
    }

    public function isPlural()
    {
        return $this->isPlural;
    }

    public function setPlural($plural)
    {
        $this->isPlural = (bool) $plural;
    }

    public function hasParameters()
    {
        return $this->hasParameters;
    }

    public function parameters()
    {
        return $this->parameters;
    }

    public function setParameters(array $parameters)
    {
        $this->hasParameters = (bool) count($parameters);
        $this->parameters = new ArrayCollection($parameters);
    }

    public function addParameter(Parameter $parameter)
    {
        $this->hasParameters = true;
        $this->parameters->add($parameter);
    }

    public function messages()
    {
        return $this->messages;
    }

    public function message($language = null, $role = 'default')
    {
        // TODO select by language and role with fallbacks
        return $this->messages;
    }

    public function setMessages(array $messages)
    {
        $this->messages = new ArrayCollection($messages);
    }

    public function addMessage(Message $message)
    {
        $this->messages->add($message);
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_translation');
        $builder->addStringKey('keyword', 100);
        $builder->addManyToOneField('domain', 'ARK\Translation\Domain');
        $builder->addField('isPlural', 'boolean', [], 'is_plural');
        $builder->addField('hasParameters', 'boolean', [], 'has_parameters');
        $builder->addOneToManyCascade('parameters', 'ARK\Translation\Parameter', 'key');
        $builder->addOneToManyCascade('messages', 'ARK\Translation\Message', 'key');
    }
}