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

class TranslationAddCommand extends Command
{
    protected function configure()
    {
        $this->setName('translation:add')
             ->setDescription('Add or Set a translation.')
             ->addArgument('keyword', InputArgument::REQUIRED, 'The translation keyword');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $question = $this->getHelper('question');

        $keyword = $input->getArgument('keyword');

        $key = Service::repository(Key::class)->find($keyword);
        if ($key) {
            $output->writeln("\nTranslation keyword exists in domain".$key->domain()->name());
        } else {
            $domains = Service::repository(Domain::class)->findAll();
            foreach ($domains as $domain) {
                $domainNames[] = $domain->name();
                $doms[$domain->name()] = $domain;
            }
            $domainQuestion = new ChoiceQuestion("Please choose the domain (Default: 'TODO'): ", $domainNames);
            $domainQuestion->setAutocompleterValues($domainNames);
            $domainName = $question->ask($input, $output, $domainQuestion);
            $domain = $doms[$domainName];
            $key = new Key($keyword, $domain);
        }

        $languages = Service::repository(Language::class)->findAll();
        foreach ($languages as $language) {
            if ($language->usedForMarkup()) {
                $langCodes[] = $language->code();
                $langs[$language->code()] = $language;
            }
        }
        $langQuestion = new ChoiceQuestion("Please choose the language (Default: 'TODO'): ", $langCodes, 'en');
        $langQuestion->setAutocompleterValues($langCodes);
        $langCode = $question->ask($input, $output, $langQuestion);
        $language = $langs[$langCode];
echo ' selected '.$language->code();
        $roles = Service::repository(Role::class)->findAll();
        foreach ($roles as $role) {
            $roleNames[] = $role->name();
            $rols[$role->name()] = $role;
        }
        $roleQuestion = new ChoiceQuestion("Please choose the role (Default: 'default'): ", $roleNames, 'default');
        $roleQuestion->setAutocompleterValues($roleNames);
        $roleName = $question->ask($input, $output, $roleQuestion);
        $role = $rols[$roleName];

        $message = Service::repository(Message::class)->findBy(['language' => $language->code(), 'key' => $key->keyword(), 'role' => $role->name()]);
        if ($message) {
            $output->writeln("\nMessage exists:");
            $output->writeln("  Text: ".$message->text());
            $output->writeln("  Notes: ".$message->notes());
            $output->writeln("Text and Notes will be replaced.");
        } else {
            echo ' no message '.$language->code();
            $message = new Message($key, $language, $role);
            echo ' in message '.$message->language()->code();
        }

        $textQuestion = new Question("Please enter the translation text: ");
        $text = $question->ask($input, $output, $textQuestion);

        $notesQuestion = new Question("Please enter any translation notes: ");
        $notes = $question->ask($input, $output, $notesQuestion);

        $message->setText($text);
        $message->setNotes($notes);
        echo ' about to persist '.$language->code();

        Service::persist($message);
        Service::flush('core');

        $output->writeln("\nTranslation added.");
    }
}
