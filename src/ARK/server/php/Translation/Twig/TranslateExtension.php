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

namespace ARK\Translation\Twig;

use Symfony\Component\Translation\TranslatorInterface;
use Twig_Extension;
use Twig_NodeVisitorInterface;
use Twig_SimpleFilter;

class TranslateExtension extends Twig_Extension
{
    private $translator;
    private $translateNodeVisitor;

    public function __construct(TranslatorInterface $translator, Twig_NodeVisitorInterface $translateNodeVisitor = null)
    {
        if (!$translateNodeVisitor) {
            $translateNodeVisitor = new TranslateNodeVisitor();
        }

        $this->translator = $translator;
        $this->translateNodeVisitor = $translateNodeVisitor;
    }

    public function getTranslator() : TranslatorInterface
    {
        return $this->translator;
    }

    public function getFilters() : iterable
    {
        return [
            new Twig_SimpleFilter('translate', [$this, 'translate']),
            new Twig_SimpleFilter('translatechoice', [$this, 'translatechoice']),
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

    public function getTranslationNodeVisitor() : Twig_NodeVisitorInterface
    {
        return $this->translateNodeVisitor;
    }

    public function translate(
        string $message = null,
        string $role = null,
        iterable $arguments = [],
        string $domain = null,
        string $locale = null
    ) : string {
        if (!$message) {
            return '';
        }
        if ($role !== null && $role !== 'default') {
            $lookup = $message.'.'.$role;
            $translation = $this->translator->trans($lookup, $arguments, $domain, $locale);
            if ($translation !== $lookup) {
                return $translation;
            }
        }
        return $this->translator->trans($message, $arguments, $domain, $locale);
    }

    public function translatechoice(
        string $message = null,
        int $count = 0,
        string $role = null,
        iterable $arguments = [],
        string $domain = null,
        string $locale = null
    ) : string {
        if (!$message) {
            return '';
        }
        if ($role !== null && $role !== 'default') {
            $lookup = $message.'.'.$role;
            $translation = $this->translator->transChoice(
                $lookup,
                $count,
                array_merge(['%count%' => $count], $arguments),
                $domain,
                $locale
            );
            if ($translation !== $lookup) {
                return $translation;
            }
        }
        return $this->translator->transChoice(
            $message,
            $count,
            array_merge(['%count%' => $count], $arguments),
            $domain,
            $locale
        );
    }

    public function getName() : string
    {
        return 'translate';
    }
}
