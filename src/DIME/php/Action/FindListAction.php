<?php

/**
 * DIME Action
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

namespace DIME\Action;

use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Layout;
use ARK\Vocabulary\Term;
use ARK\Vocabulary\Vocabulary;
use DIME\Action\DimeFormAction;
use DIME\Entity\Find;
use Symfony\Component\HttpFoundation\Request;

class FindListAction extends DimeFormAction
{
    public function __invoke(Request $request, $actorSlug = null)
    {
        $query = $request->query->all();
        $criteria = [];
        if (isset($query['type'])) {
            $type = ORM::find(Term::class, ['concept' => 'dime.find.type', 'term' => $query['type']]);
            $data['dime_find_filter_type'] = $type;
            $criteria['type'] = $type->name();
        }
        if (isset($query['period'])) {
            $period = ORM::find(Term::class, ['concept' => 'dime.period', 'term' => $query['period']]);
            $data['dime_find_filter_period'] = $period;
            $criteria['period'] = $period->name();
        }
        if (isset($query['material'])) {
            $material = ORM::find(Term::class, ['concept' => 'dime.material', 'term' => $query['material']]);
            $data['dime_find_filter_material'] = $material;
            $criteria['type'] = $type->name();
        }

        $layout = 'dime_find_search';
        $data[$layout] = ORM::findBy(Find::class, $criteria);
        $data['dime_find_list'] = $data[$layout];
        $data['dime_find_map'] = $data[$layout];
        $data['dime_find_filter'] = null;
        return $this->renderResponse($request, $data, $layout);
    }

    public function processForm(Request $request, $form, $redirect)
    {
        $data = $form->getData();
        $type = $data['dime_find_filter_type'];
        $period = $data['dime_find_filter_period'];
        $material = $data['dime_find_filter_material'];
        $query = $request->query->all();
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
