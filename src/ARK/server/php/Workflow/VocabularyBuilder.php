<?php

/**
 * ARK Workflow Registry
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

namespace ARK\Workflow;

use ARK\ORM\ORM;
use Symfony\Component\Workflow\DefinitionBuilder;
use Symfony\Component\Workflow\Transition;

class VocabularyBuilder extends DefinitionBuilder
{
    public function __construct($concept)
    {
        $vocabulary = ORM::find(Vocabulary::class, $concept);
        if ($vocabulary->hasWorkflow()) {
            foreach ($vocabulary->terms() as $term) {
                $this->addPlace($term->name());
                if ($term->isRoot()) {
                    $this->setInitialPlace($term->name());
                }
            }
            foreach ($vocabulary->terms() as $term) {
                foreach ($term->related() as $related) {
                    if ($related->type() == 'transition') {
                        $trans = new Transition($related->parameter(), $related->fromTerm()->name(), $related->toTerm()->name());
                        $this->addTransition($trans);
                    }
                }
            }
        }
    }
}