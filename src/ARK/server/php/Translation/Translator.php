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
use Symfony\Component\Translation\Translator as SymfonyTranslator;

class Translator extends SymfonyTranslator
{
    public function translate($id, $role = null, $parameters = [], $domain = null, $locale = null) : string
    {
        return $this->doTranslate($id, null, $role, $parameters, $domain, $locale);
    }

    public function translateChoice($id, int $count, $role = null, $parameters = [], $domain = null, $locale = null) : string
    {
        return $this->doTranslate($id, $count, $role, $parameters, $domain, $locale);
    }

    public function trans($id, array $parameters = [], $domain = null, $locale = null)
    {
        return $this->doTranslate($id, null, null, $parameters, $domain, $locale);
    }

    public function transChoice($id, $number, array $parameters = [], $domain = null, $locale = null)
    {
        return $this->doTranslate($id, $count, null, $parameters, $domain, $locale);
    }

    public function makeCatalogueId($id, $role = null) : string
    {
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
            return '';
        }

        if ($role instanceof Role) {
            $role = $role->id();
        }

        $parts = explode('.', $id);
        $idRole = Role::find(end($parts));
        if (!$role && !$idRole) {
            // If no role either explicit or implicit, then default
            $lookup = $id.'.default';
        } elseif (!$idRole) {
            // If only explicit role, use that
            $lookup = $id.'.'.$role;
        } elseif (!$role) {
            // If only implicit role, use that
            $lookup = $id;
        } elseif ($idRole->id() === $role) {
            // If both and match, use that
            $lookup = $id;
        } else {
            // If both and don't match, try with role first
            $lookup = $id.'.'.$role;
        }

        return $lookup;
    }

    private function doTranslate($id, $count = null, $role = null, $parameters = [], $domain = null, $locale = null) : string
    {
        if ($id instanceof LocalText) {
            return  $id->content($locale);
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
            return '';
        }

        if ($role instanceof Role) {
            $role = $role->id();
        }

        if ($domain instanceof Domain) {
            $domain = $domain->id();
        }

        if ($locale instanceof Language) {
            $locale = $locale->code();
        }

        $lookup = $this->makeCatalogueId($id, $role);

        // First try lookup on id with role added to end
        if ($count === null) {
            $msg = SymfonyTranslator::trans($lookup, $parameters, $domain, $locale);
        } else {
            $msg = SymfonyTranslator::transChoice($lookup, $count, $parameters, $domain, $locale);
        }
        if ($msg !== $lookup) {
            return $msg;
        }
        // Then try lookup on raw id
        if ($count === null) {
            $msg = SymfonyTranslator::trans($id, $parameters, $domain, $locale);
        } else {
            $msg = SymfonyTranslator::transChoice($id, $count, $parameters, $domain, $locale);
        }
        return $msg;
    }
}
