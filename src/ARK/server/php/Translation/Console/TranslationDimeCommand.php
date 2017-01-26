<?php

/**
 * ARK Translation Add Command
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

namespace ARK\Translation\Console;

use ARK\ORM\ORM;
use ARK\Service;
use ARK\Translation\Domain;
use ARK\Translation\Key;
use ARK\Translation\Language;
use ARK\Translation\Message;
use ARK\Translation\Role;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class TranslationDimeCommand extends Command
{
    protected function configure()
    {
        $this->setName('translation:dime')
             ->setDescription('Add or Set a DIME translation.')
             ->addArgument('keyword', InputArgument::OPTIONAL, 'The translation keyword');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $question = $this->getHelper('question');

        $keyword = $input->getArgument('keyword');
        if (!$keyword) {
            $keywordQuestion = new Question("Please enter the keyword: ");
            $keyword = $question->ask($input, $output, $keywordQuestion);
        }

        $key = ORM::find(Key::class, $keyword);
        if ($key) {
            $output->writeln("\nTranslation keyword exists in domain ".$key->domain()->name());
            $messages = ORM::findBy(Message::class, ['key' => $keyword]);
            foreach ($messages as $message) {
                $output->writeln($message->language()->code()." = ".$message->text());
            }
            $output->writeln("");
        } else {
            $domain = ORM::findOneBy(Domain::class, ['domain' => 'dime']);
            $key = new Key($keyword, $domain);
        }

        $da = ORM::findOneBy(Language::class, ['language' => 'da']);
        $en = ORM::findOneBy(Language::class, ['language' => 'en']);

        $role = ORM::findOneBy(Role::class, ['name' => 'default']);

        $daQuestion = new Question("Please enter the Danish text: ");
        $daText = $question->ask($input, $output, $daQuestion);

        $enQuestion = new Question("Please enter the English text: ");
        $enText = $question->ask($input, $output, $enQuestion);

        if ($daText || $enText) {
            ORM::persist($key);
        }

        if ($daText) {
            $daMsg = ORM::findOneBy(Message::class, ['language' => 'da', 'key' => $keyword, 'role' => 'default']);
            if (!$daMsg) {
                $daMsg = new Message($key, $da, $role);
            }
            $daMsg->setText($daText);
            ORM::persist($daMsg);
        }

        if ($enText) {
            $enMsg = ORM::findOneBy(Message::class, ['language' => 'en', 'key' => $keyword, 'role' => 'default']);
            if (!$enMsg) {
                $enMsg = new Message($key, $en, $role);
            }
            $enMsg->setText($enText);
            ORM::persist($enMsg);
        }

        if ($daText || $enText) {
            ORM::manager('core')->flush();
            $output->writeln("\nTranslations added.");
        }
    }
}
