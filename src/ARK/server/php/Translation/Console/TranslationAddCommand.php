<?php

/**
 * ARK Translation Add Command.
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

namespace ARK\Translation\Console;

use ARK\ORM\ORM;
use ARK\Service;
use ARK\Translation\Domain;
use ARK\Translation\Language;
use ARK\Translation\Message;
use ARK\Translation\Role;
use ARK\Translation\Translation;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class TranslationAddCommand extends Command
{
    protected function configure() : void
    {
        $this->setName('translation:add')
             ->setDescription('Add or Set a translation.')
             ->addArgument('keyword', InputArgument::REQUIRED, 'The translation keyword');
    }

    protected function execute(InputInterface $input, OutputInterface $output) : void
    {
        $question = $this->getHelper('question');

        $keyword = $input->getArgument('keyword');

        if ($translation = ORM::find(Translation::class, $keyword)) {
            $domain = $translation->domain();
            $output->writeln("\nTranslation keyword exists in domain ".$domain->id()."\n");
        } else {
            $domains = ORM::findAll(Domain::class);
            foreach ($domains as $domain) {
                $domainNames[] = $domain->id();
            }
            $domainQuestion = new ChoiceQuestion("Please choose the domain (Default: 'core'): ", $domainNames, 'core');
            $domainQuestion->setAutocompleterValues($domainNames);
            $domain = $question->ask($input, $output, $domainQuestion);
            $domain = ORM::find(Domain::class, $domain);
        }

        $languages = ORM::findAll(Language::class);
        $langCodes = [];
        foreach ($languages as $language) {
            if ($language->usedForMarkup()) {
                $langCodes[] = $language->code();
            }
        }
        $locale = Service::locale();
        $langQuestion = new ChoiceQuestion("Please choose the language (Default: '$locale'): ", $langCodes, $locale);
        $langQuestion->setAutocompleterValues($langCodes);
        $language = $question->ask($input, $output, $langQuestion);

        $roles = ORM::findAll(Role::class);
        foreach ($roles as $role) {
            $roleNames[] = $role->id();
        }
        $roleQuestion = new ChoiceQuestion("Please choose the role (Default: 'default'): ", $roleNames, 'default');
        $roleQuestion->setAutocompleterValues($roleNames);
        $role = $question->ask($input, $output, $roleQuestion);

        $message = ORM::findOneBy(Message::class, ['language' => $language, 'key' => $keyword, 'role' => $role]);
        if ($message) {
            $output->writeln("\nWARNING: Message already exists!");
            $output->writeln('  Text: '.$message->text());
            $output->writeln('  Notes: '.$message->notes());
            $output->writeln('Text and Notes will be replaced.');
        }

        $textQuestion = new Question('Please enter the translation text: ');
        $text = $question->ask($input, $output, $textQuestion);

        $notesQuestion = new Question('Please enter any translation notes: ');
        $notes = $question->ask($input, $output, $notesQuestion);

        if (!$translation) {
            $translation = new Translation($keyword, $domain);
            ORM::persist($translation);
        }
        $translation->setMessage($text, $language, $role, $notes);
        ORM::flush($translation);

        $output->writeln("\nTranslation added.");
    }
}
