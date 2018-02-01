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
use ARK\Actor\Person;
use ARK\File\File;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Translation\Translation;
use ARK\View\Page;
use ARK\Vocabulary\Term;
use ARK\Vocabulary\Vocabulary;
use ARK\Workflow\Action;
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

            // Set the selected Finder query values in the Finder filter dropdown, should be single term passed in.
            // Authorised users can search for any Finder, but Detectorists can only search for themselves.
            if ($myfinds) {
                $data['filters']['finder'] = $actor;
                $query['finder'] = [$data['filters']['finder']->id()];
            } elseif ($filterFinders && isset($query['finder'])) {
                $finder = Actor::find($query['finder']);
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
        // If on the users home search/action page, then enable advanced filtering
        $advanced = ($request->attributes->get('_route') === 'dime.home.finds');

        if ($advanced) {
            // Enable find list actions if we have finds and a single status is selected
            $haveFinds = count($data['finds']['items']) > 0;
            $haveStatus = count($query['status'] ?? []) === 1;
            $canAction = $actor->hasPermission('dime.find.workflow.action') && $haveFinds && $haveStatus;

            // Enable Treasure Claim processing iff search is for Evaluated finds with Pending treasure status
            // for a single Finder and a single Museum the user is an Agent for.
            // If the user can do Treasure Claim processing
            $canClaim = $actor->hasPermission('dime.find.treasure.claim')
                && $haveFinds
                && $haveStatus
                && count($query['finder'] ?? []) === 1
                && isset($query['museum'])
                && count($query['museum']) === 1
                && ORM::find(Museum::class, $query['museum'][0])
                && $actor->isAgentFor(ORM::find(Museum::class, $query['museum'][0]));

            if ($canAction || $canClaim) {
                if ($canAction) {
                    $statusAttribute = $data['finds']['items']->first()->schema()->attribute('process');
                    $actions = Service::workflow()->attributeActions($statusAttribute, $query['status']);
                } else {
                    $actions = new ArrayCollection();
                }
                if ($canClaim) {
                    $claim = ORM::find(Action::class, ['schma' => 'dime.find', 'action' => 'claim']);
                    $actions->add($claim);
                }
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
