<?php

/**
 * ARK Model Local Text.
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

namespace ARK\Model;

use ARK\Service;

class LocalText
{
    protected $content = [];
    protected $mediatype = 'text/plain';

    public function __construct(string $content = null, string $language = null)
    {
        if ($content) {
            $this->setContent($content, $language);
        }
    }

    public function __toString() : string
    {
        return $this->content();
    }

    public function languages() : iterable
    {
        return array_keys($this->content);
    }

    public function contents() : iterable
    {
        return $this->content;
    }

    public function content($language = null) : string
    {
        // If no language defined, use the default
        if (!$language) {
            $language = Service::locale();
        }
        // If language has text, return it
        if (isset($this->content[$language])) {
            return $this->content[$language];
        }
        // If not, try fallbacks
        $fallbacks = Service::localeFallbacks();
        foreach ($fallbacks as $fallback) {
            if (isset($this->content[$language])) {
                return $this->content[$language];
            }
        }
        // If not return first we have
        foreach ($this->languages() as $lang) {
            return $this->content[$lang];
        }
        // If not, then no text
        return '';
    }

    public function setContent(?string $content, string $language = null) : void
    {
        // If no language defined, use the default
        if (!$language) {
            $language = Service::locale();
        }
        if ($content) {
            $this->content[$language] = $content;
        } else {
            unset($this->content[$language]);
        }
    }

    public function setContents(iterable $contents) : void
    {
        $this->content = [];
        foreach ($contents as $language => $content) {
            $this->setContent($content, $language);
        }
    }

    public function mediaType() : string
    {
        return $this->mediatype;
    }

    public function setMediaType($mediatype) : void
    {
        $this->mediatype = $mediatype;
    }
}
