<?php

/**
 * DIME Controller
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
namespace DIME\Controller;

use ARK\View\Page;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Vocabulary\Term;
use DIME\Controller\EntityController;
use DIME\Entity\Find;
use Symfony\Component\HttpFoundation\Request;

class FindAddController extends EntityController
{

    public function __invoke(Request $request)
    {
        return $this->renderResponse($request, 'dime_page_find', 'finds.view');
    }

    public function buildData(Request $request, Page $page)
    {
        $actor = Service::workflow()->actor();
        $find = new Find('dime.find');
        $find->property('finder')->setValue($actor);
        $find->property('owner')->setValue($actor);
        $find->property('custodian')->setValue($actor);
        $process = ORM::find(Term::class, ['concept' => 'dime.find.process', 'term' => 'recorded']);
        $find->property('process')->setValue($process);
        $custody = ORM::find(Term::class, ['concept' => 'dime.find.custody', 'term' => 'held']);
        $find->property('custody')->setValue($custody);
        $treasure = ORM::find(Term::class, ['concept' => 'dime.treasure', 'term' => 'pending']);
        $find->property('treasure')->setValue($treasure);
        $data[$page->content()->name()] = $find;
        return $data;
    }
}
