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

namespace DIME\Controller\API;

use ARK\Http\JsonResponse;
use ARK\Vocabulary\Related;
use ARK\Vocabulary\Term;
use ARK\Vocabulary\Vocabulary;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class VocabularyController
{
    protected $term = '';

    protected $alias = '';

    protected $root = false;

    protected $parameters;

    protected $related;

    protected $descendents;

    public function __invoke(Request $request) : Response
    {
        $content = json_decode($request->getContent());
        $data = [];
        try {
            $vocabulary = Vocabulary::find($content->concept);
            if ($vocabulary) {
                $data['concept'] = $vocabulary->id();
                $data['type'] = $vocabulary->type()->id();
                $data['source'] = $vocabulary->source();
                $data['closed'] = $vocabulary->closed();
                $data['keyword'] = $vocabulary->keyword();
                $data['terms'] = [];
                // List all the terms in the vocabulary but without any relationships, i.e. for a straight list
                foreach ($vocabulary->terms(true) as $term) {
                    $data['terms'][$term->name()] = $this->serializeTerm($term);
                }
                $related = Vocabulary::findRelated($vocabulary->id());
                if (count($related)) {
                    foreach ($vocabulary->terms() as $term) {
                        $data['taxonomy'][$term->name()] = $this->serializeTerm($term);
                    }
                }
            } else {
                $data['error']['code'] = 0;
                $data['error']['message'] = 'No Vocabulary';
                $data['error']['content'] = $content;
            }
            //$data['transitions'] = $vocabulary->transitions();
        } catch (Throwable $e) {
            $data['error']['code'] = $e->getCode();
            $data['error']['message'] = $e->getMessage();
            $data['error']['content'] = $content;
        }
        return new JsonResponse($data);
    }

    protected function serializeTerm(Term $term, bool $full = true)
    {
        $data['name'] = $term->name();
        $data['alias'] = $term->alias();
        $data['default'] = $term->isDefault();
        $data['root'] = $term->isRoot();
        $data['keyword'] = $term->keyword();
        $data['parameters'] = [];
        foreach ($term->parameters() as $parameter) {
            $data['parameters'][$parameter->name()]['type'] = $parameter->type();
            $data['parameters'][$parameter->name()]['value'] = $parameter->value();
        }
        if ($full) {
            $data['related'] = [];
            foreach ($term->related() as $related) {
                $relation['from']['concept'] = $related->fromTerm()->concept()->id();
                $relation['from']['name'] = $related->fromTerm()->name();
                $relation['relation'] = $related->relation()->id();
                $relation['to']['concept'] = $related->toTerm()->concept()->id();
                $relation['to']['name'] = $related->toTerm()->name();
                $data['related'][] = $relation;
            }
            $data['descendents'] = [];
            foreach ($term->descendents() as $descendent) {
                $data['descendents'][] = $descendent->name();
            }
            $data['taxonomy'] = [];
            foreach ($term->descendents() as $descendent) {
                $data['taxonomy'][$descendent->name()] = $this->serializeTerm($descendent);
            }
        }
        return $data;
    }
}
