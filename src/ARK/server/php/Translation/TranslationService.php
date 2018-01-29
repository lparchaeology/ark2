<?php

/**
 * ARK Translation Service.
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

use ARK\Framework\Application;
use ARK\Model\LocalText;

class TranslationService
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function translate($id, $role = null, $parameters = null, $domain = null, $locale = null) : string
    {
        return $this->doTranslate($id, null, $role, $parameters, $domain, $locale);
    }

    public function translateChoice($id, int $count, $role = null, $parameters = null, $domain = null, $locale = null) : string
    {
        return $this->doTranslate($id, $count, $role, $parameters, $domain, $locale);
    }

    private function doTranslate($id, $count = null, $role = null, $parameters = null, $domain = null, $locale = null) : string
    {
        if (!$id) {
            return  '';
        }
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

        if ($role !== null && $role !== 'default') {
            $lookup = $id.'.'.$role;
            if ($count === null) {
                $msg = $this->app->trans($lookup, $parameters, $domain, $locale);
            } else {
                $msg = $this->app->transChoice($lookup, $count, $parameters, $domain, $locale);
            }
            if ($msg !== $lookup) {
                return $msg;
            }
        }

        if ($count === null) {
            return $this->app->trans($id, $parameters, $domain, $locale);
        }
        return $this->app->transChoice($id, $count, $parameters, $domain, $locale);
    }
}
