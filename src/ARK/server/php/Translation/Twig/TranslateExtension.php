<?php

/**
 * ARK Translation Twig Extension
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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\Translation\Twig;

use ARK\Translation\Twig\TranslateTokenParser;
use ARK\Translation\Twig\TranslateChoiceTokenParser;
use ARK\Translation\Twig\TranslateNodeVisitor;
use Symfony\Component\Translation\TranslatorInterface;

class TranslateExtension extends \Twig_Extension
{
    private $translator;
    private $translateNodeVisitor;

    public function __construct(TranslatorInterface $translator, \Twig_NodeVisitorInterface $translateNodeVisitor = null)
    {
        if (!$translateNodeVisitor) {
            $translateNodeVisitor = new TranslateNodeVisitor();
        }

        $this->translator = $translator;
        $this->translateNodeVisitor = $translateNodeVisitor;
    }

    public function getTranslator()
    {
        return $this->translator;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('translate', array($this, 'translate')),
            new \Twig_SimpleFilter('translatechoice', array($this, 'translatechoice')),
        );
    }

    public function getTokenParsers()
    {
        return array(
            new TranslateTokenParser(),
            new TranslateChoiceTokenParser(),
        );
    }

    public function getNodeVisitors()
    {
        return [$this->translateNodeVisitor];
    }

    public function getTranslationNodeVisitor()
    {
        return $this->translateNodeVisitor;
    }

    public function translate($message, $role = null, array $arguments = [], $domain = null, $locale = null)
    {
        if ($role !== null && $role != 'default') {
            $translation = $this->translator->trans($message.'.'.$role, $arguments, $domain, $locale);
            if ($translation != $message) {
                return $translation;
            }
        }
        return $this->translator->trans($message, $arguments, $domain, $locale);
    }

    public function translatechoice($message, $count, $role = null, array $arguments = [], $domain = null, $locale = null)
    {
        if ($role !== null && $role != 'default') {
            $translation = $this->translator->transChoice($message.'.'.$role, $count, array_merge(array('%count%' => $count), $arguments), $domain, $locale);
            if ($translation != $message) {
                return $translation;
            }
        }
        return $this->translator->transChoice($message, $count, array_merge(array('%count%' => $count), $arguments), $domain, $locale);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'translate';
    }
}
