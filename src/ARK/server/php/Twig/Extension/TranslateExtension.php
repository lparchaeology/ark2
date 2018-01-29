<?php

/**
 * ARK Translation Twig Extension.
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

namespace ARK\Twig\Extension;

use ARK\Translation\Translation;
use ARK\Twig\Node\TranslateNodeVisitor;
use ARK\Twig\TokenParser\TranslateChoiceTokenParser;
use ARK\Twig\TokenParser\TranslateTokenParser;
use Twig_Extension;
use Twig_Filter;
use Twig_NodeVisitorInterface;

class TranslateExtension extends Twig_Extension
{
    private $translateNodeVisitor;

    public function __construct(Twig_NodeVisitorInterface $translateNodeVisitor = null)
    {
        $this->translateNodeVisitor = ($translateNodeVisitor === null ? new TranslateNodeVisitor() : $translateNodeVisitor);
    }

    public function getFilters() : iterable
    {
        return [
            new Twig_Filter('translate', [$this, 'translate']),
            new Twig_Filter('translatechoice', [$this, 'translateChoice']),
        ];
    }

    public function getTokenParsers() : iterable
    {
        return [new TranslateTokenParser(), new TranslateChoiceTokenParser()];
    }

    public function getNodeVisitors() : iterable
    {
        return [$this->translateNodeVisitor];
    }

    public function translate($id, $role = null, $parameters = null, $domain = null, $locale = null) : string
    {
        return Translation::translate($id, $role, $parameters, $domain, $locale);
    }

    public function translateChoice($id, int $count, $role = null, $parameters = null, $domain = null, $locale = null) : string
    {
        return Translation::translate($id, $count, $role, $parameters, $domain, $locale);
    }

    public function getName() : string
    {
        return 'translate';
    }
}
