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

use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Page;
use ARK\Vocabulary\Term;
use ARK\Vocabulary\Vocabulary;
use DIME\Controller\DimeFormController;
use DIME\Entity\Find;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class FindListController extends DimeFormController
{
    private $actorSlug = null;

    public function __invoke(Request $request, $actorSlug = null)
    {
        $this->actorSlug = $actorSlug;
        return $this->renderResponse($request, 'dime_page_find_search');
    }

    public function buildData(Request $request, Page $page)
    {
        $query = $request->query->all();
        $criteria = [];
        if (isset($query['kommune'])) {
            $kommune = ORM::find(Term::class, [
                'concept' => 'dime.denmark.kommune',
                'term' => $query['kommune']
            ]);
            $data['dime_find_filter_kommune'] = $kommune;
            // $criteria['kommune'] = $kommune->name();
        }
        if (isset($query['type'])) {
            $type = ORM::find(Term::class, [
                'concept' => 'dime.find.type',
                'term' => $query['type']
            ]);
            $data['dime_find_filter_type'] = $type;
            $criteria['type'] = $type->name();
        }
        /*
         * if (isset($query['subtype'])) {
         * $subtype = ORM::find(Term::class, ['concept' => 'dime.find.subtype', 'term' => $query['subtype']]);
         * $data['dime_find_filter_subtype'] = $type;
         * $criteria['subtype'] = $subtype->name();
         * }
         */
        if (isset($query['period'])) {
            $period = ORM::find(Term::class, [
                'concept' => 'dime.period',
                'term' => $query['period']
            ]);
            $data['dime_find_filter_period'] = $period;
            // $criteria['period'] = $period->name();
        }
        if (isset($query['material'])) {
            $material = ORM::find(Term::class, [
                'concept' => 'dime.material',
                'term' => $query['material']
            ]);
            $data['dime_find_filter_material'] = $material;
            // $criteria['material'] = $material->name();
        }

        $resource = ORM::findBy(Find::class, $criteria);
        $data[$page->content()->name()] = $resource;
        $data['dime_find_list'] = $resource;
        $data['dime_find_map'] = (Service::isGranted('ROLE_USER') ? $resource : []);
        $data['dime_find_filter'] = null;

        try {
            $passPath = Service::configDir().'/passwords.json';
            if ($passwords = json_decode(file_get_contents($passPath), true)) {
                $user = $passwords['kortforsyningen']['user'];
                $password = $passwords['kortforsyningen']['password'];
                $kortforsyningenticket = file_get_contents("http://services.kortforsyningen.dk/service?request=GetTicket&login=$user&password=$password");
            }
            if (strlen($kortforsyningenticket) == 32) {
                $data['kortforsyningenticket'] = $kortforsyningenticket;
            } else {
                $data['kortforsyningenticket'] = false;
            }
        } catch (Exception $e) {
            // Nothing to see here, move along now...
            $data['kortforsyningenticket'] = false;
        }
        return $data;
    }

    public function processForm(Request $request, $form, $redirect)
    {
        $data = $form->getData();
        $kommune = $data['dime_find_filter_kommune'];
        $type = $data['dime_find_filter_type'];
        $period = $data['dime_find_filter_period'];
        $material = $data['dime_find_filter_material'];
        $query = $request->query->all();
        if ($kommune) {
            $query['kommune'] = $kommune->name();
        } else {
            unset($query['kommune']);
        }
        if ($type) {
            $query['type'] = $type->name();
        } else {
            unset($query['type']);
        }
        if ($period) {
            $query['period'] = $period->name();
        } else {
            unset($query['period']);
        }
        if ($material) {
            $query['material'] = $material->name();
        } else {
            unset($query['material']);
        }
        return Service::redirectPath($redirect, $query);
    }
}