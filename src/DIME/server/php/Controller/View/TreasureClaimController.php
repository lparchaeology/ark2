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

use ARK\Error\ErrorException;
use ARK\Http\Error\NotFoundError;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Page;
use DIME\DIME;
use DIME\Entity\Find;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class TreasureClaimController extends DimeFormController
{
    public function buildData(Request $request)
    {
        $id = $request->attributes->get('find');
        if (!$find = ORM::find(Find::class, $id)) {
            throw new ErrorException(new NotFoundError('ITEM_NOT_FOUND', 'Find not found', "Find $id not found"));
        }
        $data['find'] = $find;
        $data['museum'] = $find->property('museum')->value();
        $data['claimant'] = $find->property('finder')->value();
        return $data;
    }

    public function processForm(Request $request, Form $form)
    {
        $page = ORM::find(Page::class, 'dime_page_claim');
        $data = $this->buildData($request);
        $state = $this->buildState($request);
        $actor = Service::workflow()->actor();
        $item = null;
        $options['state']['actor'] = $actor;
        $options['state']['mode'] = 'view';
        $forms = $page->buildForms($data, $options);
        $context = $page->renderContext($data, ['state' => $options['state']], $forms, $form);
        return Service::view()->renderPdfResponse('pages/treasureclaimpdf.html.twig', $context, 'danefae.pdf');
    }
}
