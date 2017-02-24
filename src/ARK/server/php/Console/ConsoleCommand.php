<?php

/**
 * Ark Console Command
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
 * @php        >=5.6, >=7.0
 */

namespace ARK\Console;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

abstract class ConsoleCommand extends Command
{
    const SUCCESS_CODE = 1;
    const ERROR_CODE = 1;
    protected $query = null;
    protected $result = null;
    protected $input = null;
    protected $output = null;

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->query = $this->getHelper('question');
        $this->input = $input;
        $this->output = $output;
    }

    protected function runCommand($command, array $arguments = [])
    {
        $command = $this->getApplication()->find($command);
        $returnCode = $command->run(new ArrayInput($arguments), $this->output);
        if ($returnCode && $command->result() !== null) {
            return $command->result();
        }
        return $returnCode;
    }

    protected function result()
    {
        return $this->result;
    }

    protected function addRequiredArgument($argument, $description)
    {
        return $this->addArgument($argument, InputArgument::REQUIRED, $description);
    }

    protected function addOptionalArgument($argument, $description)
    {
        return $this->addArgument($argument, InputArgument::OPTIONAL, $description);
    }

    protected function getArgument($argument)
    {
        return $this->input->getArgument($argument);
    }

    protected function write($message)
    {
        $this->output->writeln($message);
    }

    protected function writeException($message, Exception $e)
    {
        $this->write($message.' : '.$e->getCode().' - '.$e->getMessage());
    }

    protected function ask(Question $question)
    {
        return $this->query->ask($this->input, $this->output, $question);
    }

    protected function askQuestion($text, $default = null)
    {
        if ($default) {
            return $this->ask(new Question("$text (default: $default): ", $default));
        }
        return $this->ask(new Question("$text : "));
    }

    protected function askConfirmation($text, $default = true)
    {
        if ($default) {
            return $this->ask(new ConfirmationQuestion("$text (default: Yes): ", $default));
        }
        return $this->ask(new ConfirmationQuestion("$text (default: No): ", $default));
    }

    protected function askChoice($text, $choices, $default = null, $auto = true)
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

    protected function askPassword($user = 'root', $text = null)
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
}
