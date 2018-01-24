<?php

 /**
  * ARK Console Command.
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
  * @license    GPL-3.0+.
  * @see        http://ark.lparchaeology.com/
  * @since      2.0
  */

namespace ARK\Console\Helper;

use Symfony\Component\Finder\Finder;

/**
 * Forked from Symfony-Console-Filechooser by MacFJA under MIT license
 * https://github.com/MacFJA/Symfony-Console-Filechooser.
 */
class FileFilter
{
    private $wrappedMethodHistory = [];
    private $question;
    private $attempts;
    private $validator;
    private $default;
    private $normalizer;

    public function __construct(string $question, $default = null)
    {
        $this->question = $question;
        $this->default = $default;
    }

    public function __call(string $name, array $arguments)
    {
        $supportedFinderMethod = [
            'directories',
            'date', /*'name', 'notName',*/
            /*'contains', 'notContains', 'path', 'notPath',*/
            'size',
            'exclude',
            'ignoreDotFiles',
            'ignoreVCS',
            'sort',
            'sortByName',
            'sortByType',
            'sortByAccessedTime',
            'sortByChangedTime',
            'sortByModifiedTime', /* 'filter',*/
            'followLinks',
            'ignoreUnreadableDirs', /*, 'append'*/
        ];

        if (!in_array($name, $supportedFinderMethod, true)) {
            throw new \BadMethodCallException();
        }
        $this->finderWrapperAdd($name, $arguments);

        return $this;
    }

    public function getQuestion()
    {
        return $this->question;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function getValidator()
    {
        return $this->validator;
    }

    public function setValidator(callable $validator = null)
    {
        $this->validator = $validator;

        return $this;
    }

    public function setMaxAttempts(int $attempts = null)
    {
        if ($attempts !== null && $attempts < 1) {
            throw new \InvalidArgumentException('Maximum number of attempts must be a positive value.');
        }

        $this->attempts = $attempts;

        return $this;
    }

    public function getMaxAttempts()
    {
        return $this->attempts;
    }

    public function getNormalizer()
    {
        return $this->normalizer;
    }

    public function setNormalizer($normalizer)
    {
        $this->normalizer = $normalizer;

        return $this;
    }

    public function getResultFor(string $partialPath = null)
    {
        if (file_exists($partialPath) && is_dir($partialPath)) {
            $path = $partialPath;
        } else {
            $path = dirname($partialPath);
        }

        if (!file_exists($path) || !is_dir($path) || !is_readable($path)) {
            return [];
        }

        $finder = $this->newFinder()->depth(0)->in($path);

        $paths = [];
        foreach ($finder as $file) {
            $filePath = $file->getPathname();
            if ($file->isDir()) {
                $filePath .= DIRECTORY_SEPARATOR;
            }
            if (DIRECTORY_SEPARATOR === $path && DIRECTORY_SEPARATOR === $partialPath) {
                $filePath = mb_substr($filePath, 1);
            }
            $paths[] = preg_replace('#'.preg_quote(DIRECTORY_SEPARATOR, '#').'+#', DIRECTORY_SEPARATOR, $filePath);
        }

        return $paths;
    }

    protected function newFinder()
    {
        $finder = new Finder();
        $this->finderWrapperInject($finder);

        return $finder;
    }

    protected function finderWrapperInject(Finder $finder) : void
    {
        foreach ($this->wrappedMethodHistory as $row) {
            call_user_func_array([$finder, $row['method']], $row['args']);
        }
    }

    protected function finderWrapperAdd(string $method, array $args) : void
    {
        $this->wrappedMethodHistory[] = ['method' => $method, 'args' => $args];
    }
}
