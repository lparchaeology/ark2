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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace DIME\Controller;

use ARK\Entity\Actor;
use ARK\ORM\ORM;
use ARK\Translation\Key;
use ARK\Model\Format;
use ARK\Model\Module;
use ARK\Service;
use ARK\Vocabulary\Vocabulary;
use DIME\Controller\DimeController;
use DIME\Entity\Find;
use Symfony\Component\HttpFoundation\Request;

class DemoController extends DimeController
{
    public function __invoke(Request $request)
    {
        $content = '<h2>Demonstration Links</h2>';

        $path = Service::path('actors.list');
        $content .= '<p>List of Museums in <a href="'.$path.'">Actors module</a>.
            Click through to a museum to see their responsible Municipalities.</p>';

        $path = Service::path('api.finds.collection');
        $content .= '<p>API call for <a href="'.$path.'">list of Finds</a>';

        $path = Service::path('api.finds.get', ['findSlug' => 1]);
        $content .= '<p>API call for <a href="'.$path.'">Find 1</a>';

        $vocab = ORM::find(Vocabulary::class, 'dime.period');
        $content .= Service::renderView('blocks/vocabulary.html.twig', ['vocabulary' => $vocab]);
        return Service::renderResponse('pages/page.html.twig', ['content' => $content, 'page_config' => $this->pageConfig()]);
    }
}
