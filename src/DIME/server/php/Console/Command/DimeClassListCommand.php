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
            'Term',
            'Period',
            'To Period',
            'Class',
            'Subclass 1',
            'Subclass 2',
            'Period Name',
            'To Period Name',
        ];
        $rows = [];
        foreach ($taxonomy->terms() as $class) {
            if ($only && $class->name() !== $only) {
                continue;
            }
            $rows[] = [
                $class->name(),
                '',
                '',
                $this->translate($class->keyword()),
                '',
                '',
                '',
                '',
            ];
            foreach ($class->descendents() as $subclass) {
                $rows[] = [
                    $subclass->name(),
                    $this->periodCode($subclass),
                    $this->periodCode($subclass, 'period_span'),
                    '',
                    $this->translate($subclass->keyword()),
                    '',
                    $this->periodName($subclass),
                    $this->periodName($subclass, 'period_span'),
                ];
                foreach ($subclass->descendents() as $subsubclass) {
                    $rows[] = [
                        $subsubclass->name(),
                        $this->periodCode($subsubclass),
                        $this->periodCode($subsubclass, 'period_span'),
                        '',
                        '',
                        $this->translate($subsubclass->keyword()),
                        $this->periodName($subsubclass),
                        $this->periodName($subsubclass, 'period_span'),
                    ];
                }
            }
            $rows[] = [];
        }
        $this->writeTable($headers, $rows);
    }

    private function translate(string $keyword, int $len = 30) : string
    {
        $tran = Translation::translate($keyword);
        return mb_strlen($tran) > $len ? mb_substr($tran, 0, $len).'...' : $tran;
    }

    private function periodName(Term $term, string $parm = 'period') : string
    {
        $period = $this->parmValue($term, $parm);
        if ($period) {
            $term = Vocabulary::findTerm('dime.period', $period);
            if ($term) {
                return $this->translate($term->keyword());
            }
        }
        return '';
    }

    private function periodCode(Term $term, string $parm = 'period') : string
    {
        $period = $this->parmValue($term, $parm);
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
