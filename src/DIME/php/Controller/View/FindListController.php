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

namespace DIME\Controller\View;

use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Page;
use ARK\Vocabulary\Term;
use ARK\Vocabulary\Vocabulary;
use ARK\Message\Message;
use DIME\DIME;
use DIME\Controller\View\DimeFormController;
use DIME\Entity\Find;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class FindListController extends DimeFormController
{
    private $actorSlug = null;

    public function __invoke(Request $request, $actorSlug = null)
    {
        $this->actorSlug = $actorSlug;
        return $this->handleRequest($request, 'dime_page_find_list');
    }

    public function buildData(Request $request, Page $page)
    {
        $query = $request->query->all();

        if (isset($query['municipality'])) {
            $municipalities = ORM::findBy(Term::class, [
                'concept' => 'dime.denmark.municipality',
                'term' => $query['municipality']
            ]);
            $data['dime_find_filter_municipality'] = $municipalities->toArray();
        }

        if (isset($query['type'])) {
            $types = ORM::findBy(Term::class, [
                'concept' => 'dime.find.type',
                'term' => $query['type']
            ]);
            $data['dime_find_filter_type'] = $types->toArray();
        }

        if (isset($query['period'])) {
            $periods = ORM::findBy(Term::class, [
                'concept' => 'dime.period',
                'term' => $query['period']
            ]);
            $data['dime_find_filter_period'] = $periods->toArray();
        }

        if (isset($query['material'])) {
            $materials = ORM::findBy(Term::class, [
                'concept' => 'dime.material',
                'term' => $query['material']
            ]);
            $data['dime_find_filter_material'] = $materials->toArray();
        }

        if ($query) {
            $items = Service::database()->findSearch($query);
            $resource = ORM::findBy(Find::class, [
                'item' => $items
            ]);
        } else {
            $resource = ORM::findAll(Find::class);
        }

        $data[$page->content()->name()] = $resource;
        $data['dime_find_list'] = $resource;
        // TODO Use visibility/workflow
        $data['dime_find_map'] = (Service::security()->isGranted('ROLE_USER') ? $resource : []);
        $data['dime_find_filter'] = null;
        $data['kortforsyningenticket'] = DIME::getMapTicket();
        return $data;
    }

    public function processForm(Request $request, $form, $redirect)
    {
        $data = $form->getData();
        $municipalities = $data['dime_find_filter_municipality'];
        $types = $data['dime_find_filter_type'];
        $periods = $data['dime_find_filter_period'];
        $materials = $data['dime_find_filter_material'];
        $query = [];
        if ($municipalities) {
            foreach ($municipalities as $municipality) {
                $query['municipality'][] = $municipality->name();
            }
        }
        if ($types) {
            foreach ($types as $type) {
                $query['type'][] = $type->name();
            }
        }
        if ($periods) {
            foreach ($periods as $period) {
                $query['period'][] = $period->name();
            }
        }
        if ($materials) {
            foreach ($materials as $material) {
                $query['material'][] = $material->name();
            }
        }
        return Service::redirectPath($redirect, $query);
    }
}
