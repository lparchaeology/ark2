<?php

/**
 * Ark Console Command.
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

namespace ARK\Framework\Console\Command;

use ARK\Framework\Console\Helper\FileFilter;
use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

abstract class AbstractCommand extends Command
{
    public const SUCCESS_CODE = 0;
    public const ERROR_CODE = 1;

    protected $query;
    protected $progress;
    protected $result = self::ERROR_CODE;
    protected $input;
    protected $output;

    protected function initialize(InputInterface $input, OutputInterface $output) : void
    {
        $this->query = $this->getHelper('question');
        $this->input = $input;
        $this->output = $output;
        $this->progress = new ProgressBar($this->output);
        $this->progress->setOverwrite(true);
    }

    protected function execute(InputInterface $input, OutputInterface $output) : void
    {
        $this->doExecute();
    }

    abstract protected function doExecute() : void;

    protected function interact(InputInterface $input, OutputInterface $output) : void
    {
        $this->doInteract();
    }

    protected function doInteract() : void
    {
    }

    protected function runCommand(string $command, iterable $arguments = []) : int
    {
        $command = $this->getApplication()->find($command);
        $returnCode = $command->run(new ArrayInput($arguments), $this->output);
        if ($returnCode === self::SUCCESS_CODE && $command->result() !== null) {
            return $command->result();
        }
        return $returnCode;
    }

    protected function app(string $key = null)
    {
        return $this->getApplication()->app($key);
    }

    protected function successCode() : int
    {
        return self::SUCCESS_CODE;
    }

    protected function errorCode() : int
    {
        return self::ERROR_CODE;
    }

    protected function result() : int
    {
        return $this->result;
    }

    protected function addRequiredArgument(string $argument, string $description = '') : AbstractCommand
    {
        return $this->addArgument($argument, InputArgument::REQUIRED, $description);
    }

    protected function addOptionalArgument(string $argument, string $description = '') : AbstractCommand
    {
        return $this->addArgument($argument, InputArgument::OPTIONAL, $description);
    }

    protected function getArgument(string $argument)
    {
        return $this->input->getArgument($argument);
    }

    protected function write(string $message) : void
    {
        if ($this->progress->getProgress() !== $this->progress->getMaxSteps()) {
            $this->progress->clear();
            $this->output->writeln($message);
            $this->progress->display();
        } else {
            $this->output->writeln($message);
        }
    }

    protected function writeTable(array $headers, array $rows) : void
    {
        $table = new Table($this->output);
        $table->setHeaders($headers);
        $table->setRows($rows);
        $table->render();
    }

    protected function writeException(string $message, Exception $e) : void
    {
        $this->write($message.' : '.$e->getCode().' - '.$e->getMessage());
    }

    protected function ask(Question $question)
    {
        return $this->query->ask($this->input, $this->output, $question);
    }

    protected function askQuestion(string $text, $default = null)
    {
        if ($default !== null) {
            return $this->ask(new Question("$text (default: $default): ", $default));
        }
        return $this->ask(new Question("$text : "));
    }

    protected function askConfirmation(
        string $text,
        bool $default = true,
        bool $defaultText = true,
        string $trueAnswerRegex = '/^y/i'
    ) : bool {
        if (!$defaultText) {
            $text = "$text: ";
        } elseif ($default) {
            $text = "$text (default: Yes): ";
        } else {
            $text = "$text (default: No): ";
        }
        return $this->ask(new ConfirmationQuestion($text, $default, $trueAnswerRegex));
    }

    protected function askConfirmName(string $text, string $name) : bool
    {
        $this->write($text);
        return $this->askConfirmation("To confirm, please exactly retype the name ($name)", false, false, "/$name/i");
    }

    protected function askChoice(string $text, array $choices, $default = null, bool $auto = true)
    {
        if ($default) {
            $text = "$text (default: $default): ";
        } else {
            $text = "$text : ";
        }
        $question = new ChoiceQuestion($text, $choices, $default);
        if ($auto) {
            $question->setAutocompleterValues($choices);
        }
        return $this->ask($question);
    }

    protected function askFilePath(string $text, string $default = null) : string
    {
        if ($default) {
            $text = "$text (default: $default): ";
        } else {
            $text = "$text : ";
        }
        $dialog = $this->getHelper('filechooser');
        $filter = new FileFilter($text, $default);
        return $dialog->ask($this->input, $this->output, $filter);
    }

    protected function askPassword(string $user = 'root', string $text = null) : string
    {
        if (!$text) {
            $text = "Please enter the password for the user '$user' : ";
        }
        $question = new Question($text, '');
        $question->setHidden(true);
        $question->setHiddenFallback(false);
        $question->setMaxAttempts(3);
        $password = $this->ask($question);
        return $password;
    }

    protected function askArgument($argument, $text) : void
    {
        if (!$this->input->getArgument($argument)) {
            $value = $this->askQuestion($text);
            $this->input->setArgument($argument, $value);
        }
    }

    protected function formatFileSize(string $path) : string
    {
        if (is_file($path)) {
            $size = filesize($path) ?: 0;
        } else {
            $size = 0;
            $flags = RecursiveDirectoryIterator::SKIP_DOTS | RecursiveDirectoryIterator::FOLLOW_SYMLINKS;
            $rdi = new RecursiveDirectoryIterator($path, $flags);
            $rii = new RecursiveIteratorIterator($rdi);
            foreach ($rii as $file) {
                $size += $file->getSize();
            }
        }
        return Helper::formatMemory($size);
    }
}
