<?php

/**
 * ARK Translation Keyword.
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

use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\ORM\OrmTrait;
use ARK\Service;
use ARK\Vocabulary\Parameter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;

class Keyword
{
    use OrmTrait;

    protected $keyword = '';
    protected $domain;
    protected $isPlural = false;
    protected $hasParameters = false;
    protected $parameters;
    protected $messages;

    public function __construct(string $keyword, Domain $domain, $isPlural = false)
    {
        $this->keyword = $keyword;
        $this->domain = $domain;
        $this->isPlural = $isPlural;
        $this->parameters = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function __toString() : string
    {
        return $this->id();
    }

    public function id() : string
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

    public function hasParameters() : bool
    {
        return $this->hasParameters;
    }

    public function parameters() : Collection
    {
        return $this->parameters;
    }

    public function addParameter(string $parameter) : void
    {
        $this->hasParameters = true;
        $parameter = new Parameter($this, $parameter);
        $this->parameters->add($parameter);
        ORM::persist($parameter);
    }

    public function messages() : Collection
    {
        return $this->messages;
    }

    public function message($language = null, $role = 'default') : ?Message
    {
        $language = $this->getLanguage($language);
        $role = $this->getRole($role);

        // TODO select by language and role with fallbacks
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('language', $language))
            ->andWhere(Criteria::expr()->eq('role', $role));
        $results = $this->messages()->matching($criteria);
        if ($results->isEmpty()) {
            return null;
        }
        return $results->first();
    }

    public function setMessage(string $message, $language = null, $role = null, string $notes = '') : void
    {
        $language = $this->getLanguage($language);
        $role = $this->getRole($role);

        if (!$msg = $this->message($language, $role)) {
            $msg = new Message($this, $language, $role);
            $this->messages->add($msg);
        }
        $msg->setText($message);
        $msg->setNotes($notes);
        ORM::persist($msg);
    }

    public static function findByDomain($domain) : Collection
    {
        if (is_string($domain)) {
            $domain = Domain::find($domain);
        }
        if ($domain instanceof Domain) {
            return self::findBy(['domain' => $domain->id()]);
        }
        return new ArrayCollection();
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_translation');
        $builder->addStringKey('keyword', 100);
        $builder->addManyToOneField('domain', Domain::class);
        $builder->addMappedField('is_plural', 'isPlural', 'boolean');
        $builder->addMappedField('has_parameters', 'hasParameters', 'boolean');
        $builder->addOneToManyCascadeField('parameters', Parameter::class, 'keyword');
        $builder->addOneToManyCascadeField('messages', Message::class, 'keyword');
    }

    private function getLanguage($language = null) : ?Language
    {
        $language = $language ?? Service::locale();
        if (is_string($language)) {
            $language = ORM::find(Language::class, $language);
        }
        if (!$language instanceof Language || !$language->usedForMarkup()) {
            // TODO Proper error
            throw new \Exception();
        }
        return $language;
    }

    private function getRole($role = 'default') : ?Role
    {
        $role = $role ?? 'default';
        if (is_string($role)) {
            $role = ORM::find(Role::class, $role);
        }
        if (!$role instanceof Role) {
            // TODO Proper error
            throw new \Exception();
        }
        return $role;
    }
}
