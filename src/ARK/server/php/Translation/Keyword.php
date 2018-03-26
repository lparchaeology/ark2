<?php

/**
 * ARK Translation Keyword.
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

namespace ARK\Translation;

use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\ORM\OrmTrait;
use ARK\Service;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Mapping\ClassMetadata as ValidatorMetadata;

/**
 * Translation Keyword Entity.
 */
class Keyword
{
    use OrmTrait;

    protected $keyword = '';
    protected $domain;
    protected $isPlural = false;
    protected $hasParameters = false;
    protected $parameters;
    protected $messages;

    /**
     * Construct a new Translation Keyword.
     *
     * @param string $keyword  The translation keyword ID
     * @param Domain $domain   The translation domain
     * @param bool   $isPlural If the translation is a plural form
     */
    public function __construct(string $keyword, Domain $domain, bool $isPlural = false)
    {
        $this->keyword = $keyword;
        $this->domain = $domain;
        $this->isPlural = $isPlural;
        $this->parameters = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    /**
     * Return the keyword as a string.
     *
     * @return string The string form of the translation keyword
     */
    public function __toString() : string
    {
        return $this->id();
    }

    /**
     * Return the ID of the translation.
     *
     * @return string The keyword ID
     */
    public function id() : string
    {
        return $this->keyword;
    }

    /**
     * Return the domain of the translation.
     *
     * @return Domain The translation domain
     */
    public function domain() : Domain
    {
        return $this->domain;
    }

    /**
     * Return if the translation is a plural form.
     *
     * @return bool If the translation is a plural form
     */
    public function isPlural() : bool
    {
        return $this->isPlural;
    }

    /**
     * Return if the translation has parameters.
     *
     * @return bool If the translation has parameters
     */
    public function hasParameters() : bool
    {
        return $this->hasParameters;
    }

    /**
     * Returns the parameters for this translation.
     *
     * @return Collection The translation parameters
     */
    public function parameters() : Collection
    {
        return $this->parameters;
    }

    /**
     * Add a parameter to the translation.
     *
     * @param string $parameter The parameter to add
     */
    public function addParameter(string $parameter) : void
    {
        $this->hasParameters = true;
        $parameter = new Parameter($this, $parameter);
        $this->parameters->add($parameter);
        ORM::persist($parameter);
    }

    /**
     * Returns all the translated messages for this keyword.
     *
     * @return Collection The translated messages
     */
    public function messages() : Collection
    {
        return $this->messages;
    }

    /**
     * Returns a translated message for the keyword.
     *
     * @param Language|string $language The language of the translated message
     * @param Role|string     $role     The role of the translated message
     *
     * @return Message|null The translated message
     */
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

    /**
     * Set a translated message for the keyword.
     *
     * @param string          $message  The translated message
     * @param Language|string $language The language of the translated message
     * @param Role|string     $role     The role of the translated message
     * @param string          $notes    Translator notes for the message
     */
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

    /**
     * Query the ORM for all Keywords within a Domain.
     *
     * @param Domain|string $domain The Domain to query for
     *
     * @return Collection The collection of messages
     */
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

    /**
     * Load Entity Validator Metadata.
     *
     * @param ValidatorMetadata $metadata The Symfony validator metadata object
     */
    public static function loadValidatorMetadata(ValidatorMetadata $metadata) : void
    {
        $metadata->addConstraint(
            new UniqueEntity([
                'fields' => 'keyword',
                'em' => 'config',
            ])
        );
        $metadata->addPropertyConstraints('keyword', [
            new Type('string'),
            new NotBlank(),
            new Length(['max' => 100]),
            new Regex('/^[a-z.]$/us'),
        ]);
        $metadata->addPropertyConstraints('domain', [
            new Type('object'),
            new Valid(),
            new NotNull(),
        ]);
        $metadata->addPropertyConstraints('isPlural', [
            new Type('bool'),
            new NotNull(),
        ]);
        $metadata->addPropertyConstraints('hasParameters', [
            new Type('bool'),
            new NotNull(),
        ]);
    }

    /**
     * Load Entity ORM Metadata.
     *
     * @param ClassMetadata $metadata The Doctrine ORM metadata object
     */
    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_translation_keyword');

        // Key
        $builder->addStringKey('keyword', 100);

        // Attributes
        $builder->addManyToOneField('domain', Domain::class);
        $builder->addMappedField('is_plural', 'isPlural', 'boolean');
        $builder->addMappedField('has_parameters', 'hasParameters', 'boolean');

        // Relationships
        $builder->addOneToManyCascadeField('parameters', Parameter::class, 'keyword');
        $builder->addOneToManyCascadeField('messages', Message::class, 'keyword');
    }

    /**
     * Get a Language entity.
     *
     * @param Language|string $language The language or code to get
     *
     * @return Language The language entity
     */
    private function getLanguage($language = null) : Language
    {
        $language = $language ?? Service::locale();
        if (is_string($language)) {
            $language = Language::find($language);
        }
        if (!$language instanceof Language || !$language->usedForMarkup()) {
            // TODO Proper error
            throw new \Exception();
        }
        return $language;
    }

    /**
     * Get a Role entity.
     *
     * @param Role|string $role The role or code to get
     *
     * @return Role The role entity
     */
    private function getRole($role = 'default') : Role
    {
        $role = $role ?? 'default';
        if (is_string($role)) {
            $role = Role::find($role);
        }
        if (!$role instanceof Role) {
            // TODO Proper error
            throw new \Exception();
        }
        return $role;
    }
}
