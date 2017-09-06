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

use ARK\Actor\Actor;
use ARK\Actor\Museum;
use ARK\Actor\Person;
use ARK\File\File;
use ARK\File\MediaType;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Page;
use ARK\Vocabulary\Term;
use ARK\Workflow\Action;
use DIME\DIME;
use DIME\Entity\Find;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class FindListController extends DimeFormController
{
    public function buildData(Request $request)
    {
        $query = $request->query->all();
        // If on the users home search/action page, then enable advanced filtering
        $advanced = ($request->attributes->get('_route') === 'dime.home.finds');
        $actor = Service::workflow()->actor();
        // Only allow to filter for all Finders if explicitly granted
        $filterFinders = $actor->hasPermission('dime.find.filter.finder');
        // Only allow to filter for all Museums if explicitly granted
        $filterMuseums = $actor->hasPermission('dime.find.filter.museum');
        // Otherwise only allow advanced filtering for the current users finds
        $myfinds = $advanced && $actor->hasPermission('dime.find.create') && !$filterFinders;

        if (isset($query['municipality'])) {
            $municipalities = ORM::findBy(Term::class, [
                'concept' => 'dime.denmark.municipality',
                'term' => $query['municipality'],
            ]);
            $data['filters']['municipality'] = $municipalities->toArray();
        }

        if (isset($query['class'])) {
            $classes = ORM::findBy(Term::class, [
                'concept' => 'dime.find.class',
                'term' => $query['class'],
            ]);
            $data['filters']['class'] = $classes->toArray();
        }

        if (isset($query['period'])) {
            $period = ORM::findOneBy(Term::class, [
                'concept' => 'dime.period',
                'term' => $query['period'],
            ]);
            $data['filters']['period'] = $period;
            $query['period'][] = $period->name();
            foreach ($period->descendents() as $descendent) {
                $query['period'][] = $descendent->name();
            }
        }

        if (isset($query['material'])) {
            $materials = ORM::findBy(Term::class, [
                'concept' => 'dime.material',
                'term' => $query['material'],
            ]);
            $data['filters']['material'] = $materials->toArray();
        }

        if ($advanced) {
            $museums = new ArrayCollection();
            $finders = new ArrayCollection();
            $status = new ArrayCollection();
            $treasures = new ArrayCollection();
            $agencies = $this->museums($actor);

            if (!$filterMuseums && $agencies->count() > 0 && !isset($query['museum'])) {
                $query['museum'] = $agencies->first()->id();
            }
            if (isset($query['museum'])) {
                $museums = ORM::findBy(Museum::class, [
                    'id' => $query['museum'],
                ]);
                if ($filterMuseums) {
                    $data['filters']['museum'] = $museums->toArray();
                } else {
                    foreach ($museums as $museum) {
                        if ($agencies->contains($museum)) {
                            $data['filters']['museum'] = $museum;
                            break;
                        }
                    }
                    if (isset($data['filters']['museum'])) {
                        $query['museum'] = [$data['filters']['museum']->id()];
                    } else {
                        unset($query['museum']);
                    }
                }
            }

            if ($myfinds) {
                $data['filters']['finder'] = $actor;
                $query['finder'] = [$data['filters']['finder']->id()];
            } elseif ($filterFinders && isset($query['finder'])) {
                $finder = ORM::findOneBy(Person::class, [
                    'id' => $query['finder'],
                ]);
                $data['filters']['finder'] = $finder;
            }

            if (isset($query['status'])) {
                $status = ORM::findBy(Term::class, [
                    'concept' => 'dime.find.process',
                    'term' => $query['status'],
                ]);
                $data['filters']['status'] = $status->first();
            }

            if (isset($query['treasure'])) {
                $treasures = ORM::findBy(Term::class, [
                    'concept' => 'dime.treasure',
                    'term' => $query['treasure'],
                ]);
                $data['filters']['treasure'] = $treasures->first();
            }
        }

        if ($query) {
            $items = Service::database()->findSearch($query);
            $finds = ORM::findBy(Find::class, ['id' => $items]);
        } else {
            $finds = ORM::findAll(Find::class);
        }

        $visible = new ArrayCollection();
        foreach ($finds as $find) {
            if ($find->visibility()->name() === 'public' || Service::workflow()->can($actor, 'view', $find)) {
                $visible[] = $find;
            }
        }

        if ($query) {
            Service::view()->addInfoFlash('dime.find.query.set', ['%items%' => count($visible)]);
        }

        $data['finds']['items'] = $visible;
        $data['finds']['selected'] = [];
        if ($myfinds || Service::workflow()->actor()->hasPermission('dime.find.read.location')) {
            $data['map']['finds'] = $visible;
        } else {
            $data['map']['finds'] = [];
        }
        $data['map']['kortforsyningenticket'] = DIME::getMapTicket();
        return $data;
    }

    public function buildState(Request $request, $data) : iterable
    {
        $state = parent::buildState($request, $data);
        $actor = $state['actor'];
        $query = $request->query->all();
        // If on the users home search/action page, then enable advanced filtering
        $advanced = ($request->attributes->get('_route') === 'dime.home.finds');

        if ($advanced) {
            // Enable Treasure Claim processing iff search is for Evaluated finds with Pending treasure status
            // for a single Finder and a single Museum the user is an Agent for.
            // If the user can do Treasure Claim processing
            $claim = $actor->hasPermission('dime.find.treasure.claim')
                && count($data['finds']['items']) > 0
                && isset($query['museum']) && count($query['museum']) === 1
                && ORM::find(Museum::class, $query['museum'][0])
                && $actor->isAgentFor(ORM::find(Museum::class, $query['museum'][0]))
                && isset($query['finder']) && count($query['finder']) === 1
                && isset($query['status']) && count($query['status']) === 1;

            if ($claim) {
                $state['workflow']['mode'] = 'edit';
                $state['actions'] = Service::workflow()->updateActions($actor, $data['finds']['items'][0]);
                $state['select']['actions']['choices'] = $state['actions'];
                $state['select']['actions']['choice_value'] = 'name';
                $state['select']['actions']['choice_name'] = 'name';
                $state['select']['actions']['choice_label'] = 'keyword';
                $state['select']['actions']['multiple'] = false;
                $state['select']['actions']['placeholder'] = Service::translate('core.placeholder');
            }

            $select['choice_value'] = 'id';
            $select['choice_name'] = 'id';
            $select['choice_label'] = 'fullname';

            // Filter by Museum
            // If the user is explicitly granted permission, they can filter for all museums.
            // Otherwise the user is only able to filter museums they have explicitly granted permission for
            if ($actor->hasPermission('dime.find.filter.museum')) {
                $select['choices'] = ORM::findAll(Museum::class);
                $select['multiple'] = true;
                $select['placeholder'] = Service::translate('core.placeholder');
            } else {
                $select['choices'] = $this->museums($actor);
                $select['multiple'] = false;
                if (count($select['choices']) > 0) {
                    $select['placeholder'] = false;
                } else {
                    $select['placeholder'] = '';
                    $select['mode'] = 'readonly';
                }
            }
            $state['select']['museum'] = $select;

            // Filter by Finder.
            // If the user is explicitly granted permission, they can filter for all actors.
            // If the user is able to create new finds, then they are allowed to filter for their own finds
            // Otherwise they cannot filter by Finder
            unset($select['mode']);
            if ($actor->hasPermission('dime.find.filter.finder')) {
                $finders = Service::database()->getFinders();
                $select['choices'] = ORM::findBy(Person::class, ['id' => $finders]);
                $select['multiple'] = false;
                $select['placeholder'] = Service::translate('core.placeholder');
            } elseif ($actor->hasPermission('dime.find.create')) {
                $select['choices'] = [$actor];
                $select['multiple'] = false;
                $select['placeholder'] = false;
            } else {
                $select['choices'] = [];
                $select['multiple'] = false;
                $select['placeholder'] = '';
                $select['mode'] = 'readonly';
            }
            $state['select']['finder'] = $select;
        }
        return $state;
    }

    public function processForm(Request $request, Form $form) : void
    {
        Service::view()->clearFlashes();
        $clicked = $form->getClickedButton()->getName();
        if ($clicked === 'apply') {
            //$selected = $form['finds']['selected']->getData();
            $actor = Service::workflow()->actor();
            $data = $form->getData();
            $finds = $data['items'];
            $action = $data['actions'];
            //$subject = $data['actors'];
            //$date = $data['date'];
            //$text = $data['textarea'];
            foreach ($finds as $find) {
                $action->apply($actor, $find);
                ORM::persist($find);
            }
            if ($action->name() === 'claim') {
                $page = ORM::find(Page::class, 'dime_page_claim');
                $content = $page->content();
                $data['finds'] = $finds;
                $data['museum'] = $finds[0]->property('museum')->value();
                $data['claimant'] = $finds[0]->property('finder')->value();
                $state['actor'] = $actor;
                $state['mode'] = 'view';
                $state['workflow']['mode'] = 'edit';
                $options['state'] = $state;
                $forms = $content->buildForms($data, $state, $options);
                $context = $page->pageContext($data, $state, $forms);
                $pdf = Service::view()->renderPdf('pages/treasureclaimpdf.html.twig', $context);
                $mediatype = new MediaType('application/pdf');
                $file = File::createFromContent($mediatype, 'danefae', $pdf);
                foreach ($finds as $find) {
                    $find->property('claim')->setValue($file);
                }
            }
            ORM::flush($find);
            if (isset($file)) {
                $request->attributes->set('_file', $file->id());
            } else {
                $message = $action->keyword();
                Service::view()->addSuccessFlash($message);
            }
        }

        if ($clicked === 'search') {
            $municipalities = $form['municipality']->getData();
            $classes = $form['class']->getData();
            $period = $form['period']->getData();
            $materials = $form['material']->getData();
            $museums = $form['museum']->getData();
            $finders = $form['finder']->getData();
            $status = $form['status']->getData();
            $treasures = $form['treasure']->getData();
            $query = [];
            if ($municipalities) {
                $query['municipality'] = $this->queryName($municipalities);
            }
            if ($classes) {
                $query['class'] = $this->queryName($classes);
            }
            if ($period) {
                $query['period'] = $this->queryName($period);
            }
            if ($materials) {
                $query['material'] = $this->queryName($materials);
            }
            if ($museums) {
                $query['museum'] = $this->queryId($museums);
            }
            if ($finders) {
                $query['finder'] = $this->queryId($finders);
            }
            if ($status) {
                $query['status'] = $this->queryName($status);
            }
            if ($treasures) {
                $query['treasure'] = $this->queryName($treasures);
            }
            $request->attributes->set('parameters', $query);
        }
    }

    private function queryName($data)
    {
        if (is_iterable($data)) {
            $query = [];
            foreach ($data as $datum) {
                $query[] = $datum->name();
            }
            return $query;
        }
        return [$data->name()];
    }

    private function queryId($data)
    {
        if (is_iterable($data)) {
            $query = [];
            foreach ($data as $datum) {
                $query[] = $datum->id();
            }
            return $query;
        }
        return [$data->id()];
    }

    private function museums(Actor $actor) : iterable
    {
        $museums = new ArrayCollection();
        foreach ($actor->agencies() as $agency) {
            if ($agency instanceof Museum) {
                $museums[] = $agency;
            }
        }
        return $museums;
    }
}
