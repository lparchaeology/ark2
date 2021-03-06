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

use Symfony\Component\Translation\DataCollectorTranslator as SymfonyDataCollectorTranslator;

/**
 * @author Abdellatif Ait boudad <a.aitboudad@gmail.com>
 * @license MIT
 */
class DataCollectorTranslator extends SymfonyDataCollectorTranslator
{
    private $translator;
    private $messages = [];

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->translator, $method], $args);
    }

    public function translate($id, $role = null, array $parameters = [], $domain = null, $locale = null)
    {
        $message = $this->translator->generateMessage($id, null, $role, $parameters, $domain, $locale);
        $this->collectMessage($message);
        return $message['translation'] ?? '';
    }

    public function translateChoice($id, $number, $role = null, array $parameters = [], $domain = null, $locale = null)
    {
        $message = $this->translator->generateMessage($id, $number, $role, $parameters, $domain, $locale);
        $this->collectMessage($message);
        return $message['translation'] ?? '';
    }

    public function trans($id, array $parameters = [], $domain = null, $locale = null)
    {
        $message = $this->translator->generateMessage($id, null, null, $parameters, $domain, $locale);
        $this->collectMessage($message);
        return $message['translation'] ?? '';
    }

    public function transChoice($id, $number, array $parameters = [], $domain = null, $locale = null)
    {
        $message = $this->translator->generateMessage($id, $number, null, $parameters, $domain, $locale);
        $this->collectMessage($message);
        return $message['translation'] ?? '';
    }

    public function setLocale($locale) : void
    {
        $this->translator->setLocale($locale);
    }

    public function getLocale()
    {
        return $this->translator->getLocale();
    }

    public function getCatalogue($locale = null)
    {
        return $this->translator->getCatalogue($locale);
    }

    public function getFallbackLocales()
    {
        return $this->translator->getFallbackLocales();
    }

    public function getCollectedMessages()
    {
        return $this->messages;
    }

    private function collectMessage($message) : void
    {
        if ($message['keyword'] === null || $message['role'] === null) {
            return;
        }
        $domain = $message['domain'] ?? 'messages';
        $id = $message['id'];
        $catalogue = $this->translator->getCatalogue($message['locale']);
        $locale = $catalogue->getLocale();
        if ($catalogue->defines($id, $domain)) {
            $state = self::MESSAGE_DEFINED;
        } elseif ($catalogue->has($id, $domain)) {
            $state = self::MESSAGE_EQUALS_FALLBACK;

            $fallbackCatalogue = $catalogue->getFallbackCatalogue();
            while ($fallbackCatalogue) {
                if ($fallbackCatalogue->defines($id, $domain)) {
                    $locale = $fallbackCatalogue->getLocale();
                    break;
                }

                $fallbackCatalogue = $fallbackCatalogue->getFallbackCatalogue();
            }
        } else {
            $state = self::MESSAGE_MISSING;
        }

        $message['locale'] = $locale;
        $message['state'] = $state;
        $this->messages[] = $message;
    }
}
