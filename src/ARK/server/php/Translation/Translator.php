<?php

/**
 * ARK Translation Service.
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

use ARK\Model\LocalText;
use ARK\Service;
use Symfony\Component\Translation\Translator as SymfonyTranslator;

class Translator extends SymfonyTranslator
{
    public function translate($id, $role = null, $parameters = [], $domain = null, $locale = null) : string
    {
        $message = $this->generateMessage($id, null, $role, $parameters, $domain, $locale);
        return $message['translation'] ?? '';
    }

    public function translateChoice($id, int $count, $role = null, $parameters = [], $domain = null, $locale = null) : string
    {
        $message = $this->generateMessage($id, $count, $role, $parameters, $domain, $locale);
        return $message['translation'] ?? '';
    }

    public function trans($id, array $parameters = [], $domain = null, $locale = null)
    {
        $message = $this->generateMessage($id, null, null, $parameters, $domain, $locale);
        return $message['translation'] ?? '';
    }

    public function transChoice($id, $number, array $parameters = [], $domain = null, $locale = null)
    {
        $message = $this->generateMessage($id, $count, null, $parameters, $domain, $locale);
        return $message['translation'] ?? '';
    }

    public function generateMessage($id, $count = null, $role = null, $parameters = [], $domain = null, $locale = null) : iterable
    {
        if ($role instanceof Role) {
            $role = $role->id();
        }
        if (!$role) {
            $role = 'default';
        }

        if ($domain instanceof Domain) {
            $domain = $domain->id();
        }
        if (!$domain) {
            $domain = 'messages';
        }

        if ($locale instanceof Language) {
            $locale = $locale->code();
        }
        if (!$locale) {
            $locale = Service::locale();
        }

        $message = [
            'locale' => $locale,
            'domain' => $domain,
            'id' => $id,
            'keyword' => $id,
            'role' => $role,
            'translation' => $id,
            'parameters' => $parameters,
            'transChoiceNumber' => $count,
        ];

        if ($id instanceof LocalText) {
            $message['keyword'] = null;
            $message['role'] = null;
            $message['translation'] = $id->content($locale);
            return $message;
        }

        if (is_object($id) && method_exists($id, 'keyword')) {
            $id = $id->keyword();
        }
        if (is_array($id) && isset($id['keyword'])) {
            $id = $id['keyword'];
        }
        if ($id instanceof Keyword) {
            $id = $id->id();
        }

        if (!is_string($id)) {
            $message['keyword'] = null;
            $message['translation'] = null;
            return $message;
        }

        $parts = explode('.', $id);
        $idRole = Role::find(end($parts));
        if (!$role && !$idRole) {
            // If no role either explicit or implicit, then default
            $keyword = $id;
            $role = 'default';
        } elseif (!$role) {
            // If only implicit role, use that
            $keyword = implode('.', $parts);
            $role = $idRole->id();
        } elseif ($idRole instanceof Role && $idRole->id() === $role) {
            // If both and match, use that
            $keyword = implode('.', $parts);
        } else {
            $keyword = $id;
        }

        // The correct ARK translation id is the requested keyword with the requested role
        $lookup = $keyword.'.'.$role;
        $message['id'] = $lookup;
        $message['keyword'] = $keyword;
        $message['role'] = $role;
        $catalogue = $this->getCatalogue($locale);
        if ($catalogue->has($lookup, $domain)) {
            $message['translation'] = $this->translation($lookup, $count, $parameters, $domain, $locale);
            return $message;
        }

        // Fallback to the default role when the requested role is not found
        if ($role !== 'default') {
            $lookup = $keyword.'.default';
            if ($catalogue->has($lookup, $domain)) {
                $message['translation'] = $this->translation($lookup, $count, $parameters, $domain, $locale);
                return $message;
            }
        }

        // Next try lookup on id without role, i.e. if not an ARK translation
        $lookup = $id;
        if ($catalogue->has($lookup, $domain)) {
            $message['id'] = $lookup;
            $message['keyword'] = null;
            $message['role'] = null;
            $message['translation'] = $this->translation($lookup, $count, $parameters, $domain, $locale);
            return $message;
        }

        // Otherwise fail and return the requested id to display instead
        $message['translation'] = $id;
        return $message;
    }

    private function translation($id, $count, $parameters, $domain, $locale) : string
    {
        if ($count === null) {
            return SymfonyTranslator::trans($id, $parameters, $domain, $locale);
        }
        return SymfonyTranslator::transChoice($id, $count, $parameters, $domain, $locale);
    }
}
