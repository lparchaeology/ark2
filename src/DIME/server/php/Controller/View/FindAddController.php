<?php

/**
 * DIME Controller.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
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
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace DIME\Controller\View;

use ARK\Model\Item;
use ARK\ORM\ORM;
use ARK\Service;
use DIME\DIME;
use DIME\Entity\Find;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class FindAddController extends DimePageController
{
    public function buildData(Request $request)
    {
        $actor = Service::workflow()->actor();
        $find = new Find('dime.find');
        $find->setValue('finder', $actor);
        $find->setValue('process', 'recorded');

        // If cloning an existing find, then check if user is allowed to clone, then copy relevent fields
        $query = $request->query->all();
        if (isset($query['id'])) {
            if ($source = ORM::find(Find::class, $query['id'])) {
                if ($source->value('finder')->id() === $actor->id()) {
                    $find->setValue('case', $source->value('case'));
                    $find->setValue('finddate', $source->value('finddate'));
                    $find->setValue('finder_place', $source->value('finder_place'));
                    $find->setValue('class', $source->value('class'));
                    $find->setValue('classification', $source->value('classification'));
                    $find->setValue('dating', $source->value('dating'));
                    $find->setValue('material', $source->value('material'));
                }
            }
        }
        $data['find'] = $find;
        return $data;
    }

    public function buildState(Request $request, $data) : iterable
    {
        $state = parent::buildState($request, $data);
        $actor = $state['actor'];
        if (!$actor->hasPermission('dime.find.register.any')) {
            $state['select']['finder']['choices'] = [$actor];
        }
        return $state;
    }

    public function processForm(Request $request, Form $form) : void
    {
        $find = $form->getData();
        $actor = Service::workflow()->actor();
        ORM::persist($find);
        Service::workflow()->apply($actor, 'record', $find);
        ORM::flush($find);
        $parameters['id'] = $find->id();
        $request->attributes->set('parameters', $parameters);
        Service::view()->addSuccessFlash('dime.find.add', $parameters);
    }

    protected function item($data) : ?Item
    {
        return $data['find'];
    }
}
