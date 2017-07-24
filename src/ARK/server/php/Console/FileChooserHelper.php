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
 *
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Console;

use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Forked from Symfony-Console-Filechooser by MacFJA under MIT license
 * https://github.com/MacFJA/Symfony-Console-Filechooser.
 */
class FileChooserHelper extends Helper
{
    private $inputStream;

    public function getName()
    {
        return 'filechooser';
    }

    public function ask(InputInterface $input, OutputInterface $output, FileFilter $filter)
    {
        if (!$input->isInteractive()) {
            return $filter->getDefault();
        }

        if (!$filter->getValidator()) {
            return $this->doAsk($output, $filter);
        }

        $that = $this;

        $interviewer = function () use ($output, $filter, $that) {
            return $that->doAsk($output, $filter);
        };

        return $this->validateAttempts($interviewer, $output, $filter);
    }

    public function setInputStream($stream)
    {
        if (!is_resource($stream)) {
            throw new \InvalidArgumentException('Input stream must be a valid resource.');
        }

        $this->inputStream = $stream;
    }

    public function getInputStream()
    {
        return $this->inputStream;
    }

    private function doAsk(OutputInterface $output, FileFilter $filter)
    {
        $inputStream = $this->inputStream ?: STDIN;
        $message = $filter->getQuestion();
        $output->write($message);
        $ret = trim($this->autocomplete($output, $filter, $inputStream));
        $ret = strlen($ret) > 0 ? $ret : $filter->getDefault();
        if ($normalizer = $filter->getNormalizer()) {
            return $normalizer($ret);
        }

        return $ret;
    }

    private function autocomplete(OutputInterface $output, FileFilter $filter, $inputStream)
    {
        $autocomplete = $filter->getResultFor($filter->getDefault());
        $ret = $filter->getDefault();

        $i = strlen($ret);
        $ofs = 0;
        $matches = $autocomplete;
        $numMatches = count($matches);

        $sttyMode = shell_exec('stty -g');

        // Disable icanon (so we can fread each keypress) and echo (we'll do echoing here instead)
        shell_exec('stty -icanon -echo');

        // Add highlighted text style
        $output->getFormatter()->setStyle('hl', new OutputFormatterStyle('black', 'white'));

        $output->write($ret);
        $this->searchCompletion($ret, $filter, $ofs, $matches, $numMatches);
        $this->displaySuggestion($output, $matches, $numMatches, $ofs, $i);

        // Read a keypress
        while (!feof($inputStream)) {
            $c = fread($inputStream, 1);

            // Backspace Character
            if ("\177" === $c) {
                if (0 === $numMatches && 0 !== $i) {
                    --$i;
                    // Move cursor backwards
                    $output->write("\033[1D");
                }

                if ($i === 0) {
                    $ofs = -1;
                    $matches = $filter->getResultFor($ret);
                    $numMatches = count($matches);
                } else {
                    $matches = [];
                    $numMatches = 0;
                }

                // Pop the last character off the end of our string
                $ret = substr($ret, 0, $i);
            } elseif ("\033" === $c) {
                // Did we read an escape sequence?
                $c .= fread($inputStream, 2);

                // A = Up Arrow. B = Down Arrow
                if (isset($c[2]) && ('A' === $c[2] || 'B' === $c[2])) {
                    if ('A' === $c[2] && -1 === $ofs) {
                        $ofs = 0;
                    }

                    if (0 === $numMatches) {
                        continue;
                    }

                    $ofs += ('A' === $c[2]) ? -1 : 1;
                    $ofs = ($numMatches + $ofs) % $numMatches;
                }
            } elseif (ord($c) < 32) {
                if ("\t" === $c || "\n" === $c) {
                    if ($numMatches > 0 && -1 !== $ofs) {
                        $ret = $matches[$ofs];
                        // Echo out remaining chars for current match
                        $output->write(substr($ret, $i));
                        $i = strlen($ret);
                        $this->searchCompletion($ret, $filter, $ofs, $matches, $numMatches);
                    }

                    if ("\n" === $c) {
                        $output->write($c);
                        break;
                    }

                    //$numMatches = 0;
                }
                if ("\t" !== $c) {
                    //continue;
                }
            } else {
                $output->write($c);
                $ret .= $c;
                ++$i;
                $this->searchCompletion($ret, $filter, $ofs, $matches, $numMatches);
            }

            $this->displaySuggestion($output, $matches, $numMatches, $ofs, $i);
        }

        // Reset stty so it behaves normally again
        shell_exec(sprintf('stty %s', $sttyMode));

        return $ret;
    }

    private function searchCompletion(string $partial = null, FileFilter $filter, int &$ofs, array &$matches, int &$numMatches)
    {
        $ret = $partial;
        $i = strlen($ret);

        $numMatches = 0;
        $matches = [];
        $ofs = 0;

        $autocomplete = $filter->getResultFor($ret);

        foreach ($autocomplete as $value) {
            // If typed characters match the beginning chunk of value (e.g. [AcmeDe]moBundle)
            if (0 === strpos($value, $ret) && $i !== strlen($value)) {
                $matches[$numMatches++] = $value;
            }
        }
    }

    private function displaySuggestion(OutputInterface $output, array $matches, int $numMatches, int $ofs, int $partialLength)
    {
        $output->write("\033[K");

        if ($numMatches > 0 && -1 !== $ofs) {
            // Save cursor position
            $output->write("\0337");
            // Write highlighted text
            $output->write('<hl>'.substr($matches[$ofs], $partialLength).'</hl>');
            // Restore cursor position
            $output->write("\0338");
        }
    }

    private function validateAttempts(callable $interviewer, OutputInterface $output, FileFilter $filter)
    {
        $error = null;
        $attempts = $filter->getMaxAttempts();
        while (null === $attempts || $attempts--) {
            if ($error !== null) {
                if (null !== $this->getHelperSet() && $this->getHelperSet()->has('formatter')) {
                    $message = $this->getHelperSet()->get('formatter')->formatBlock($error->getMessage(), 'error');
                } else {
                    $message = '<error>'.$error->getMessage().'</error>';
                }

                $output->writeln($message);
            }

            try {
                return call_user_func($filter->getValidator(), $interviewer());
            } catch (\Exception $error) {
            }
        }

        throw $error;
    }
}
