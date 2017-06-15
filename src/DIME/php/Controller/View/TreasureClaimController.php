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

use ARK\Error\ErrorException;
use ARK\Http\Error\NotFoundError;
use ARK\ORM\ORM;
use ARK\View\Page;
use ARK\Service;
use DIME\DIME;
use DIME\Controller\View\DimeFormController;
use DIME\Entity\Find;
use Symfony\Component\HttpFoundation\Request;

class TreasureClaimController extends DimeFormController
{
    public function __invoke(Request $request, $id)
    {
        return $this->handleRequest($request, 'dime_page_claim', ['find' => $id]);
    }

    public function buildData(Request $request, $slugs = [])
    {
        if (!$find = ORM::find(Find::class, $slugs['find'])) {
            throw new ErrorException(new NotFoundError('ITEM_NOT_FOUND', 'Find not found', "Find ".$slugs['find']." not found"));
        }
        $data['find'] = $find;
        $data['museum'] = $find->property('museum')->value();
        $data['claimant'] = $find->property('finder')->value();
        return $data;
    }

    public function processForm(Request $request, $form, $redirect)
    {
        $page = ORM::find(Page::class, 'dime_page_claim');
        $data = $this->buildData($request);
        $forms = $page->buildForms('view', $data, []);
        $context = $page->renderContext('view', $data, [], $forms, $form);
        return Service::renderPdfResponse('pages/treasureclaimpdf.html.twig', $context, 'danefae.pdf');
    }
}
