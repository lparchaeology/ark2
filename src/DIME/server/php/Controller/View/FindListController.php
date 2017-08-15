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
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Vocabulary\Term;
use ARK\Workflow\Action;
use DIME\DIME;
use DIME\Entity\Find;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class FindListController extends DimeFormController
{
    public function buildState(Request $request) : iterable
    {
        $state = parent::buildState($request);

        if ($request->attributes->get('_route') === 'dime.home.finds') {
            $actor = Service::workflow()->actor();

            if ($actor->hasPermission('dime.find.filter.museum')) {
                $state['options']['museum']['choices'] = ORM::findAll(Museum::class);
                $state['options']['museum']['multiple'] = true;
                $state['options']['museum']['placeholder'] = '';
            } else {
                $state['options']['museum']['choices'] = $this->museums($actor);
                $state['options']['museum']['multiple'] = false;
                if (count($state['options']['museum']['choices']) > 0) {
                    $state['options']['museum']['placeholder'] = false;
                } else {
                    $state['options']['museum']['mode'] = 'readonly';
                }
            }

            if ($actor->hasPermission('dime.find.filter.finder')) {
                $finders = Service::database()->getFinders();
                $state['options']['finder']['choices'] = ORM::findBy(Person::class, ['item' => $finders]);
                $state['options']['finder']['multiple'] = false;
            } elseif ($actor->hasPermission('dime.find.create')) {
                $state['options']['finder']['choices'] = [$actor];
                $state['options']['finder']['multiple'] = false;
                $state['options']['finder']['placeholder'] = false;
            } else {
                $state['options']['finder']['choices'] = [];
                $state['options']['finder']['multiple'] = false;
                $state['options']['finder']['mode'] = 'readonly';
            }

            if ($actor->hasPermission('dime.find.create')) {
                dump('can create');
                $state['options']['status']['multiple'] = true;
                $state['options']['status']['placeholder'] = '';
                $state['options']['treasure']['multiple'] = true;
                $state['options']['treasure']['placeholder'] = '';
            }
        }
        dump($state);

        return $state;
    }

    public function buildData(Request $request)
    {
        $query = $request->query->all();
        $advanced = ($request->attributes->get('_route') === 'dime.home.finds');
        $actor = Service::workflow()->actor();
        $filterFinders = $actor->hasPermission('dime.find.filter.finder');
        $filterMuseums = $actor->hasPermission('dime.find.filter.museum');
        $myfinds = $advanced && $actor->hasPermission('dime.find.create') && !$filterFinders;
        $claim = $actor->hasPermission('dime.find.treasure.claim');

        if (isset($query['municipality'])) {
            $municipalities = ORM::findBy(Term::class, [
                'concept' => 'dime.denmark.municipality',
                'term' => $query['municipality'],
            ]);
            $data['filters']['municipality'] = $municipalities->toArray();
        }

        if (isset($query['type'])) {
            $types = ORM::findBy(Term::class, [
                'concept' => 'dime.find.type',
                'term' => $query['type'],
            ]);
            $data['filters']['type'] = $types->toArray();
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
            $status = null;
            $treasures = new ArrayCollection();
            $agencies = $this->museums($actor);

            if (!$filterMuseums && $agencies->count() > 0 && !isset($query['museum'])) {
                $query['museum'] = $agencies->first()->id();
            }
            if (isset($query['museum'])) {
                $museums = ORM::findBy(Museum::class, [
                    'item' => $query['museum'],
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
                    'item' => $query['finder'],
                ]);
                $data['filters']['finder'] = $finder;
            }

            if (isset($query['status'])) {
                $status = ORM::findBy(Term::class, [
                    'concept' => 'dime.find.process',
                    'term' => $query['status'],
                ]);
                $data['filters']['status'] = ($myfinds ? $status->toArray() : $status->first());
            }

            if (isset($query['treasure'])) {
                $treasures = ORM::findBy(Term::class, [
                    'concept' => 'dime.treasure',
                    'term' => $query['treasure'],
                ]);
                $data['filters']['treasure'] = ($myfinds ? $treasures->toArray() : $treasures->first());
            }
        }

        if ($query) {
            $items = Service::database()->findSearch($query);
            $finds = ORM::findBy(Find::class, ['item' => $items]);
        } else {
            $finds = ORM::findAll(Find::class);
        }

        if ($claim) {
            $claim = (
                $finds
                && $status->count() === 1
                && $status->first()->name() === 'dime.find.process.evaluated'
                && $treasures->count() === 1
                && $treasures->first()->name() === 'dime.treasure.pending'
                && $finders->count() === 1
                && $museums->count() === 1
                && $actor->isAgentFor($museums->first())
            );
        }

        $visible = new ArrayCollection();
        foreach ($finds as $find) {
            if ($find->visibility()->name() === 'public' || Service::workflow()->can($actor, 'view', $find)) {
                $visible[] = $find;
            }
        }

        if ($query) {
            $this->addFlash($request, 'info', 'dime.find.query.set', ['%items%' => count($visible)]);
        }

        $data['finds']['items'] = $visible;
        $data['finds']['selected'] = [];
        $data['actions'] = [];
        if ($claim) {
            $data['actions'][] = ORM::findBy(Action::class, ['schma' => 'dime.find', 'action' => 'claim']);
        }
        if ($myfinds || Service::workflow()->actor()->hasPermission('dime.find.read.location')) {
            $data['map']['finds'] = $visible;
        } else {
            $data['map']['finds'] = [];
        }
        $data['map']['kortforsyningenticket'] = DIME::getMapTicket();
        return $data;
    }

    public function buildWorkflow(Request $request, $data, iterable $state) : iterable
    {
        $actor = $state['actor'];
        $workflow['actor'] = $actor;
        $workflow['mode'] = 'edit';
        $query = $request->query->all();
        if (isset($query['status']) && isset($data['finds']['items'][0])) {
            //$workflow['actions'] = Service::workflow()->updateActions($actor, $data['finds'][0]);
        }
        $workflow['actions'] = $data['actions'];
        return $workflow;
    }

    public function processForm(Request $request, Form $form) : void
    {
        $clicked = $form->getClickedButton()->getName();

        if ($clicked === 'apply') {
            $selected = $form['finds']['selected']->getData();
        }

        if ($clicked === 'search') {
            $municipalities = $form['municipality']->getData();
            $types = $form['type']->getData();
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
            if ($types) {
                $query['type'] = $this->queryName($types);
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
