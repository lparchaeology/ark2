<?php

/**
 * ARK Translation Domain Entity.
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

namespace ARK\Translation;

use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Service;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping\ClassMetadata;

class Translation
{
    protected $keyword = '';
    protected $domain;
    protected $isPlural = false;
    protected $hasParameters = false;
    protected $parameters;
    protected $messages;

    public function __construct(string $keyword, Domain $domain)
    {
        $this->keyword = $keyword;
        $this->domain = $domain;
        $this->parameters = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function keyword() : string
    {
        return $this->keyword;
    }

    public function domain() : Domain
    {
        return $this->domain;
    }

    public function isPlural() : bool
    {
        return $this->isPlural;
    }

    public function setPlural(bool $plural) : void
    {
        $this->isPlural = $plural;
    }

    public function hasParameters() : bool
    {
        return $this->hasParameters;
    }

    public function parameters() : ArrayCollection
    {
        return $this->parameters;
    }

    public function setParameters(iterable $parameters) : void
    {
        $this->hasParameters = (bool) count($parameters);
        $this->parameters = new ArrayCollection($parameters);
    }

    public function addParameter(Parameter $parameter) : void
    {
        $this->hasParameters = true;
        $this->parameters->add($parameter);
    }

    public function messages() : ArrayCollection
    {
        return $this->messages;
    }

    public function message(string $language = null, string $role = 'default') : Message
    {
        // TODO select by language and role with fallbacks
        if ($language === null) {
            $language = Service::locale();
        }
        $language = ORM::find(Language::class, $language);

        $role = ORM::find(Role::class, $role);

        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('language', $language))
            ->andWhere(Criteria::expr()->eq('role', $role));
        return $this->messages->matching($criteria)->first();
    }

    public function setMessages(iterable $messages) : void
    {
        $this->messages = new ArrayCollection($messages);
    }

    public function addMessage(Message $message) : void
    {
        $this->messages->add($message);
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_translation');
        $builder->addStringKey('keyword', 100);
        $builder->addManyToOneField('domain', Domain::class);
        $builder->addField('isPlural', 'boolean', [], 'is_plural');
        $builder->addField('hasParameters', 'boolean', [], 'has_parameters');
        $builder->addOneToManyCascade('parameters', Parameter::class, 'keyword');
        $builder->addOneToManyCascade('messages', Message::class, 'keyword');
    }
}
