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
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace DIME\Console\Command;

use ARK\Framework\Console\Command\AbstractCommand;
use ARK\Translation\Translation;
use ARK\Vocabulary\Term;
use ARK\Vocabulary\Vocabulary;

class DimeClassListCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this->setName('dime:class:list')
            ->setDescription('List all find classifications.')
            ->addOptionalArgument('class', 'The class to list');
    }

    protected function doExecute() : void
    {
        $only = $this->input->getArgument('class');
        $taxonomy = Vocabulary::find('dime.find.class');
        $headers = [
            'Class',
            'Subclass 1',
            'Subclass 2',
            'Term',
            'Keyword',
            'Period Term',
            'Period',
            'Start Year',
            'End Year',
        ];
        $rows = [];
        foreach ($taxonomy->terms() as $class) {
            if ($only && $class->name() !== $only) {
                continue;
            }
            $rows[] = [
                Translation::translate($class->keyword()),
                '',
                '',
                $class->name(),
                $class->keyword(),
                '',
                '',
                '',
                '',
            ];
            foreach ($class->descendents() as $subclass) {
                $rows[] = [
                    '',
                    Translation::translate($subclass->keyword()),
                    '',
                    $subclass->name(),
                    $subclass->keyword(),
                    $this->periodCode($subclass),
                    $this->periodName($subclass),
                    $this->parmValue($subclass, 'year_start'),
                    $this->parmValue($subclass, 'year_end'),
                ];
                foreach ($subclass->descendents() as $subsubclass) {
                    $rows[] = [
                        '',
                        '',
                        Translation::translate($subsubclass->keyword()),
                        $subsubclass->name(),
                        $subsubclass->keyword(),
                        $this->periodCode($subsubclass),
                        $this->periodName($subsubclass),
                        $this->parmValue($subsubclass, 'year_start'),
                        $this->parmValue($subsubclass, 'year_end'),
                    ];
                }
            }
            $rows[] = [];
        }
        $this->writeTable($headers, $rows);
    }

    private function periodName(Term $term) : string
    {
        $period = $this->parmValue($term, 'period');
        if ($period) {
            $term = Vocabulary::findTerm('dime.period', $period);
            if ($term) {
                return Translation::translate($term->keyword());
            }
        }
        return '';
    }

    private function periodCode(Term $term) : string
    {
        $period = $this->parmValue($term, 'period');
        if ($period) {
            $term = Vocabulary::findTerm('dime.period', $period);
            if ($term) {
                return $term->name();
            }
        }
        return '';
    }

    private function parmValue(Term $term, string $name) : string
    {
        $parm = $term->parameter($name);
        return $parm ? $parm->value() : '';
    }
}
