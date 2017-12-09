<?php

/**
 * ARK View Dump Command.
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

namespace ARK\View\Console\Command;

use ARK\Framework\Console\Command\AbstractCommand;
use ARK\ORM\ORM;
use ARK\View\Element;
use ARK\View\Page;

class ViewPageDumpCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this->setName('view:page:dump')
            ->setDescription('Dump a View Page')
            ->addOptionalArgument('page', 'The Page to dump');
    }

    protected function doExecute() : void
    {
        $page = $this->getArgument('page');
        $page = ORM::find(Page::class, $page);
        $this->write('');
        $this->write('Page : '.$page->id());
        $this->write('');
        $this->write('Mode             : '.$page->mode());
        $this->write('Visibility       : '.$page->visibility()->name());
        $this->write('Read Permission  : '.$page->readPermission()->id());
        $this->write('Write Permission : '.$page->updatePermission()->id());
        $this->write('');
        $this->write('Header   : '.$page->header()->id());
        $this->write('Sidebar  : '.$page->sidebar()->id());
        $this->write('Content  : '.$page->content()->id());
        $this->write('Footer   : '.$page->footer()->id());
        $this->write('Template : '.$page->template());
        $this->write('');
        $this->writeElement($page->content());
        $this->write('');
    }

    protected function writeElement(Element $element, int $depth = 0) : void
    {
        $pre = $depth > 0 ? str_repeat('-', $depth).' ' : '';
        $type = str_pad('['.$element->type()->id().']', 10);
        $name = str_pad($element->name() ? '"'.$element->name().'"' : '', 30);
        $this->write(str_pad($pre.$type.$element->id(), 40).$name);
        if (method_exists($element, 'grid')) {
            foreach ($element->grid() as $rdx => $row) {
                foreach ($row as $cdx => $col) {
                    foreach ($col as $seq => $cell) {
                        $this->writeElement($cell->element(), $depth + 1);
                    }
                }
            }
        }
    }

    protected function doInteract() : void
    {
        $pages = ORM::findAll(Page::class);
        foreach ($pages as $page) {
            $ids[$page->id()] = $page->id();
        }
        $page = $this->getArgument('page');
        if (!isset($ids[$page])) {
            $page = $this->askChoice('Please choose the page to use', array_keys($ids));
            $this->setArgument('page', $page);
        }
    }
}
