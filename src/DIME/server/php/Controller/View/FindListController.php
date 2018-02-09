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

use ARK\File\File;
use ARK\ORM\ORM;
use ARK\Security\Actor;
use ARK\Security\Person;
use ARK\Service;
use ARK\Translation\Translation;
use ARK\View\Page;
use ARK\Vocabulary\Term;
use ARK\Vocabulary\Vocabulary;
use ARK\Workflow\Action;
use DateTime;
use DIME\DIME;
use DIME\Entity\Find;
use DIME\Entity\Museum;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class FindListController extends DimePageController
{
    public function buildData(Request $request)
    {
        // Fetch any query parms passed in
        $query = $request->query->all();
        // If on the Actors home search/action page, then enable advanced filtering
        $advanced = ($request->attributes->get('_route') === 'dime.home.finds');
        // On Public Search page, don't show All Finds by default, require a query first
        $showAll = $query || $advanced;
        // Decide what the user can search for.
        $actor = Service::workflow()->actor();
        // Only allow to filter for all Finders if explicitly granted
        $filterFinders = $actor->hasPermission('dime.find.filter.finder');
        // Only allow to filter for all Museums if explicitly granted
        $filterMuseums = $actor->hasPermission('dime.find.filter.museum');
        // Otherwise only allow advanced filtering for the current Actors finds
        $myfinds = $advanced && $actor->hasPermission('dime.find.create') && !$filterFinders;

        // Set the selected Municipality query values in the Municipality filter dropdown, can be multiple terms
        if (isset($query['municipality'])) {
            $municipalities = (is_array($query['municipality']) ? $query['municipality'] : [$query['municipality']]);
            $municipalities = Vocabulary::findTerms('dime.denmark.municipality', $municipalities);
            $data['filters']['municipality'] = $municipalities->toArray();
        }

        // Set the selected Find Class query values in the Find Class filter dropdown, can be multiple terms
        if (isset($query['class'])) {
            $classes = (is_array($query['class']) ? $query['class'] : [$query['class']]);
            $classes = Vocabulary::findTerms('dime.find.class', $classes);
            $data['filters']['class'] = $classes->toArray();
        }

        // Set the selected Period query values in the Period filter dropdown, should be single term passed in
        if (isset($query['period'])) {
            $periods = (is_array($query['period']) ? $query['period'] : [$query['period']]);
            $periods = Vocabulary::findTerms('dime.period', $periods);
            $period = $periods->first();
            $data['filters']['period'] = $period;
            // Period includes any descendent periods
            $query['period'][] = $period->name();
            foreach ($period->descendents() as $descendent) {
                $query['period'][] = $descendent->name();
            }
        }

        // Set the selected Material query values in the Material filter dropdown, can be multiple terms
        if (isset($query['material'])) {
            $materials = (is_array($query['material']) ? $query['material'] : [$query['material']]);
            $materials = Vocabulary::findTerms('dime.material', $materials);
            $data['filters']['material'] = $materials->toArray();
        }

        // Advanced search options if on Actor's Find search page
        if ($advanced) {
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

            // Set the selected Finder query values in the Finder filter dropdown, should be single term passed in.
            // Authorised users can search for any Finder, but Detectorists can only search for themselves.
            if ($myfinds) {
                $data['filters']['finder'] = $actor;
                $query['finder'] = [$data['filters']['finder']->id()];
            } elseif ($filterFinders && isset($query['finder'][0])) {
                $finder = Actor::find($query['finder'][0]);
                $data['filters']['finder'] = $finder;
            }

            // Set the selected Status query values in the Status filter dropdown, should be single term passed in.
            // It is important that this is only a single value as it determines the bulk action that can be applied.
            if (isset($query['status'])) {
                $statuses = (is_array($query['status']) ? $query['status'] : [$query['status']]);
                $statuses = Vocabulary::findTerms('dime.find.process', $statuses);
                $data['filters']['status'] = $statuses->first();
            }

            // Set the selected Treasure query values in the Treasure filter dropdown, should be single term passed in.
            if (isset($query['treasure'])) {
                $treasures = (is_array($query['treasure']) ? $query['treasure'] : [$query['treasure']]);
                $treasures = Vocabulary::findTerms('dime.treasure', $treasures);
                $data['filters']['treasure'] = $treasures->first();
            }

            // Set the selected Visibility query values in the Visibility filter dropdown, should be single term passed in.
            if (isset($query['visibility'])) {
                $visibility = (is_array($query['visibility']) ? $query['visibility'] : [$query['visibility']]);
                $visibility = Vocabulary::findTerms('core.visibility', $visibility);
                $data['filters']['visibility'] = $visibility->first();
            }

            // Set the selected Custody query values in the Custody filter dropdown, should be single term passed in.
            if (isset($query['custody'])) {
                $custody = (is_array($query['custody']) ? $query['custody'] : [$query['custody']]);
                $custody = Vocabulary::findTerms('dime.find.custody', $custody);
                $data['filters']['custody'] = $custody->first();
            }

            // Set the selected Find Date query values in the Find Date pickers.
            if (isset($query['find_date'])) {
                $data['filters']['find_date'] = new DateTime($query['find_date']);
            }
            if (isset($query['find_date_span'])) {
                $data['filters']['find_date_span'] = new DateTime($query['find_date_span']);
            }
        } else {
            // Public finds search excludes anything not yet reviewed, but don't include in query string or filter dropdown
            $query['treasure'] = ['appraisal', 'treasure', 'not'];
        }

        // Perform the query as defined
        if ($query) {
            $items = DIME::findSearch($query);
            $finds = ORM::findBy(Find::class, ['id' => $items]);
        } else {
            $finds = ORM::findAll(Find::class);
        }

        // Of the finds matching the search criteria, only include those that are Visible to the current Actor
        $visible = new ArrayCollection();
        foreach ($finds as $find) {
            if ($find->visibility()->name() === 'public' || Service::workflow()->can($actor, 'view', $find)) {
                $visible[] = $find;
            }
        }

        // Finally, decide what of the Visible Finds to show on screen

        // Finds to list in table
        $data['finds']['items'] = new ArrayCollection();
        // Finds to select in table
        $data['finds']['selected'] = [];
        // Find points to show in map
        $data['map']['finds'] = [];
        if ($advanced || $showAll) {
            // If advanced search, or public search with query options, show results of the query
            $data['finds']['items'] = $visible;
            Service::view()->addInfoFlash('dime.find.query.found', ['%items%' => count($visible)]);
            // Set finds to show as points on map, Viewing Find Locations as points on map is restricted
            if ($myfinds || Service::workflow()->actor()->hasPermission('dime.find.read.location')) {
                $data['map']['finds'] = $visible;
            }
        } else {
            // If public search page without a query only say how many are in system
            $data['finds']['items'] = new ArrayCollection();
            Service::view()->addInfoFlash('dime.find.query.available', ['%items%' => count($visible)]);
        }

        $data['map']['kortforsyningenticket'] = DIME::getMapTicket();
        return $data;
    }

    public function buildState(Request $request, $data) : iterable
    {
        $state = parent::buildState($request, $data);
        $actor = $state['actor'];
        $query = $request->query->all();

        // If on the users home search/action page, then enable advanced filtering and actions
        $advanced = ($request->attributes->get('_route') === 'dime.home.finds');
        $haveFinds = count($data['finds']['items'] ?? []) > 0;

        // If Advanced mode and we have Finds selected, see what Actions could be applied
        if ($advanced && $haveFinds) {
            // Set up some flags for what query inputs we have
            $haveStatus = count($query['status'] ?? []) === 1;
            $haveTreasure = count($query['treasure'] ?? []) === 1;
            $haveFinder = count($query['finder'] ?? []) === 1;
            $haveCustody = count($query['custody'] ?? []) === 1;
            $haveVisibility = count($query['visibility'] ?? []) === 1;
            $haveMuseum = count($query['museum'] ?? []) === 1;
            $museum = $haveMuseum ? Museum::find($query['museum'][0]) : null;

            // Enable find list actions if we have finds and a single status is selected
            $canAction = $haveFinds && $actor->hasPermission('dime.find.workflow.action');

            // Enable Treasure Claim processing iff search is for Finds sent to the Museum
            // for a single Finder and a single Museum the user is an Agent for.
            $canClaim = $haveMuseum
                && $haveFinder
                && $haveStatus
                && $haveCustody
                && $actor->hasPermission('dime.find.treasure.claim')
                && $actor->isAgentFor($museum);

            $actions = [];
            $item = $data['finds']['items']->first();

            // Get the Process Status Actions
            if ($haveStatus) {
                $attribute = $item->schema()->attribute('process');
                $statusActions = Service::workflow()->attributeActions($attribute, $query['status']);
                $actions = array_merge($actions, $statusActions->toArray());
            }

            // Get the Treasure Status Actions
            if ($haveTreasure) {
                $attribute = $item->schema()->attribute('treasure');
                $treasureActions = Service::workflow()->attributeActions($attribute, $query['treasure']);
                $actions = array_merge($actions, $treasureActions->toArray());
            }

            // Get the Custody Status Actions
            if ($haveCustody) {
                $attribute = $item->schema()->attribute('custody');
                $custodyActions = Service::workflow()->attributeActions($attribute, $query['custody']);
                $actions = array_merge($actions, $custodyActions->toArray());
            }

            // Get the Visibility Status Actions
            if ($haveVisibility) {
                $attribute = $item->schema()->attribute('visibility');
                $visibilityActions = Service::workflow()->attributeActions($attribute, $query['visibility']);
                $actions = array_merge($actions, $visibilityActions->toArray());
            }

            // Check the Actions can be performed
            foreach ($actions as $key => $action) {
                if ($key === 'claim' && !$canClaim) {
                    unset($actions[$key]);
                } elseif (!Service::workflow()->can($actor, $key, $item)) {
                    unset($actions[$key]);
                }
            }

            // Populate the set of Actions that can be applied
            if (count($actions) > 0) {
                $state['workflow']['mode'] = 'edit';
                $state['actions'] = $actions;
                $select['choices'] = $state['actions'];
                $select['choice_value'] = 'name';
                $select['choice_name'] = 'name';
                $select['choice_label'] = 'keyword';
                $select['multiple'] = false;
                $select['placeholder'] = Translation::translate('core.placeholder');
                $state['select']['actions'] = $select;
            }
            // TODO Hide the Action widget???
        }

        // If Advanced mode then set up the Advanced filter widgets
        if ($advanced) {
            unset($select);
            $select['choice_value'] = 'id';
            $select['choice_name'] = 'id';
            $select['choice_label'] = 'fullname';

            // Filter by Museum
            // If the user is explicitly granted permission, they can filter for all museums.
            // Otherwise the user is only able to filter museums they have explicitly granted permission for
            if ($actor->hasPermission('dime.find.filter.museum')) {
                $select['choices'] = ORM::findAll(Museum::class);
                $select['multiple'] = true;
                $select['placeholder'] = Translation::translate('core.placeholder');
            } else {
                $select['choices'] = $this->museums($actor);
                $select['multiple'] = false;
                if (count($select['choices']) > 0) {
                    $select['placeholder'] = false;
                } else {
                    $select['placeholder'] = '';
                    $select['modus'] = 'readonly';
                }
            }
            $state['select']['museum'] = $select;

            // Filter by Finder.
            // If the user is explicitly granted permission, they can filter for all actors.
            // If the user is able to create new finds, then they are allowed to filter for their own finds
            // Otherwise they cannot filter by Finder
            unset($select['mode']);
            if ($actor->hasPermission('dime.find.filter.finder')) {
                $finders = DIME::getFinders();
                $select['choices'] = ORM::findBy(Person::class, ['id' => $finders]);
                $select['multiple'] = false;
                $select['placeholder'] = Translation::translate('core.placeholder');
            } elseif ($actor->hasPermission('dime.find.create')) {
                $select['choices'] = [$actor];
                $select['multiple'] = false;
                $select['placeholder'] = false;
                $select['modus'] = 'readonly';
            } else {
                $select['choices'] = [];
                $select['multiple'] = false;
                $select['placeholder'] = '';
                $select['modus'] = 'readonly';
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
            $actor = Service::workflow()->actor();
            $data = $form->getData();
            $items = $data['selected'] ?? [];
            $finds = ORM::findBy(Find::class, ['id' => $items]);
            $action = $data['actions'];
            foreach ($finds as $find) {
                $action->apply($actor, $find);
                ORM::persist($find);
            }
            if ($action->name() === 'claim') {
                $file = DIME::generateTreasureClaimFile($finds, $finds[0]->value('museum'), $finds[0]->value('finder'), $actor);
                foreach ($finds as $find) {
                    $find->setValue('claim', $file);
                }
            }
            ORM::flush('data');
            if (isset($file)) {
                $file = $find->value('claim');
                $file->setName('Danefae'.$file->id().'.pdf');
                ORM::flush($file);
                $request->attributes->set('_file', $file->id());
            } else {
                $message = $action->keyword();
                Service::view()->addSuccessFlash($message);
            }
            $request->attributes->set('parameters', $request->query->all());
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
            $visibility = $form['visibility']->getData();
            $custody = $form['custody']->getData();
            $findDate = $form['find_date']->getData();
            $findDateSpan = $form['find_date_span']->getData();
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
            if ($visibility) {
                $query['visibility'] = $this->queryName($visibility);
            }
            if ($custody) {
                $query['custody'] = $this->queryName($custody);
            }
            if ($findDate) {
                $query['find_date'] = $findDate->format('Y-m-d');
            }
            if ($findDateSpan) {
                $query['find_date_span'] = $findDateSpan->format('Y-m-d');
            }
            $request->attributes->set('parameters', $query);
        }

        if ($clicked === 'clear') {
            $request->attributes->set('parameters', []);
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
