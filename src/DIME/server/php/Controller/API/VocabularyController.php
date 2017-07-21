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

namespace DIME\Controller\API;

use ARK\Http\JsonResponse;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Vocabulary\Term;
use ARK\Vocabulary\Vocabulary;
use Symfony\Component\HttpFoundation\Request;

class VocabularyController
{
    protected $term = '';

    protected $alias = '';

    protected $root = false;

    protected $parameters = null;

    protected $related = null;

    protected $descendents = null;

    public function __invoke(Request $request)
    {
        $content = json_decode($request->getContent());
        try {
            $vocabulary = ORM::find(Vocabulary::class, $content->concept);
            $data['concept'] = $vocabulary->concept();
            $data['type'] = $vocabulary->type();
            $data['source'] = $vocabulary->source();
            $data['closed'] = $vocabulary->closed();
            $data['keyword'] = $vocabulary->keyword();
            $data['terms'] = [];
            foreach ($vocabulary->terms() as $term) {
                $data['terms'][$term->name()] = $this->serializeTerm($term);
            }
            //$data['transitions'] = $vocabulary->transitions();
        } catch (Exception $e) {
            $data['error']['code'][$e->getCode()];
            $data['error']['message'][$e->getMessage()];
        }
        return new JsonResponse($data);
    }

    public function serializeTerm(Term $term)
    {
        $data['name'] = $term->name();
        $data['alias'] = $term->alias();
        $data['default'] = $term->isDefault();
        $data['root'] = $term->isRoot();
        $data['parameters'] = [];
        foreach ($term->parameters() as $parameter) {
            $data['parameters'][$parameter->name()]["type"] = $parameter->type();
            $data['parameters'][$parameter->name()]["value"] = $parameter->value();
        }
        $data['related'] = [];
        foreach ($term->related() as $related) {
            $data['related']['from'] = $related->fromTerm()->name();
            $data['related']['relation'] = $related->type();
            $data['related']['to'] = $related->toTerm()->name();
        }
        $data['descendents'] = [];
        foreach ($term->descendents() as $descendent) {
            $data['descendents'][] = $descendent->name();
        }
        return $data;
    }
}