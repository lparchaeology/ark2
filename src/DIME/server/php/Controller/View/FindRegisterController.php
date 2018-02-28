<?php

/**
 * DIME Controller.
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

namespace DIME\Controller\View;

use ARK\Model\Item;
use ARK\ORM\ORM;
use ARK\Service;
use DIME\DIME;
use DIME\Entity\Find;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class FindRegisterController extends DimePageController
{
    public function buildData(Request $request)
    {
        $actor = Service::workflow()->actor();
        $find = new Find('dime.find');
        $find->setValue('finder', $actor);
        $find->setValue('finddate', 'NOW');
        $find->setValue('process', 'recorded');
        $data['find'] = $find;

        $query = $request->query->all();
        if (isset($query['prev'])) {
            $data['prev'] = Find::find($query['prev']);
        } else {
            $data['prev'] = null;
        }

        return $data;
    }

    public function processForm(Request $request, Form $form) : void
    {
        $find = $form->getData();
        $actor = Service::workflow()->actor();
        // TODO Strict checking?
        $location = $find->value('location');
        $municipality = DIME::findMunicipality($location->asText());
        if ($municipality) {
            $find->setValue('municipality', $municipality);
            $museum = DIME::getMunicipalityMuseum($municipality->name());
            if ($museum) {
                $find->setValue('museum', $museum);
            }
        }
        ORM::persist($find);
        Service::workflow()->apply($actor, 'record', $find);
        ORM::flush($find);
        $parameters['prev'] = $find->id();
        $request->attributes->set('parameters', $parameters);
        Service::view()->addSuccessFlash('dime.find.registered', ['id' => $find->id()]);
    }

    protected function item($data) : ?Item
    {
        return $data['find'];
    }
}
