<?php

/**
 * DIME Action
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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace DIME\Action;

use ARK\Entity\Actor;
use ARK\ORM\ORM;
use ARK\Translation\Key;
use ARK\Model\Format;
use ARK\Model\Module;
use ARK\Service;
use ARK\Vocabulary\Vocabulary;
use DIME\Entity\Find;
use Symfony\Component\HttpFoundation\Request;

class TestViewAction
{
    public function __invoke(Request $request)
    {
        $contents = Service::translate('site.welcome');

        if ($finds = ORM::findAll(Find::class)) {
            $contents .= '<br /><br />Finds<br /><br />';
            foreach ($finds as $find) {
                $contents .= $find->id().'   '.$find->label().'   '.$find->schema()->name().'<br />';
                foreach ($find->properties() as $property) {
                    if (is_array($property->value())) {
                        $value = '['.implode(', ', $property->value()).']';
                    } elseif ($property->value() instanceof \DateTime) {
                        $value = $property->value()->format('Y-m-d H:i:s');
                    } else {
                        $value = $property->value();
                    }
                    $contents .= '---- '.$property->name().' = '.$value.'<br />';
                }
            }
        }

        if ($actors = ORM::findAll(Actor::class)) {
            $contents .= '<br /><br />Actors<br /><br />';
            foreach ($actors as $actor) {
                $contents .= $actor->id().'   '.$actor->label().'   '.$actor->schema()->name().'<br />';
            }
        }

        if ($modules = ORM::findAll(Module::class)) {
            $contents .= '<br /><br />Modules<br /><br />';
            foreach ($modules as $module) {
                $contents .= $module->name().'   '.$module->resource().'<br />';
                foreach ($module->schemas() as $schema) {
                    $contents .= '---- '.$schema->name().'   '.$schema->module()->entity().'<br />';
                    foreach ($schema->typeNames() as $type) {
                        $contents .= '-------- '.$type.'<br />';
                        foreach ($schema->attributes($type) as $attribute) {
                            $contents .= '------------ '.$attribute->name().'   '.$attribute->format()->name().'   '.$attribute->format()->keyword().'<br />';
                        }
                        foreach ($schema->associations($type) as $association) {
                            $contents .= '------------ '.$association->name().'   '.$association->inverseSchema()->name().'<br />';
                        }
                    }
                    if (!$schema->useTypes()) {
                        foreach ($schema->attributes() as $attribute) {
                            $contents .= '-------- '.$attribute->name().'   '.$attribute->format()->name().'<br />';
                        }
                        foreach ($schema->associations() as $association) {
                            $contents .= '-------- '.$association->name().'   '.$association->inverseSchema()->name().'<br />';
                        }
                    }
                }
            }
        }

        if ($trans = ORM::findAll(Key::class)) {
            $contents .= '<br /><br />Translations<br /><br />';
            foreach ($trans as $tran) {
                $contents .= $tran->domain()->name().'   '.$tran->keyword().'<br />';
                foreach ($tran->parameters() as $parm) {
                    $contents .= '---- '.$parm->name().'<br />';
                }
                foreach ($tran->messages() as $msg) {
                    $contents .= '---- '.$msg->language()->code().'   '.$msg->text().'<br />';
                }
            }
        }

        if ($formats = ORM::findAll(Format::class)) {
            $contents2 = '<br /><br />Formats<br /><br />';
            foreach ($formats as $format) {
                $contents2 .= $format->name().'   '.get_class($format).'<br />';
                $contents2 .= '---- '.$format->type()->name().'<br />';
                if ($format->hasAttributes()) {
                    foreach ($format->attributes() as $attribute) {
                        $contents2 .= '-------- '.$attribute->name().'   '.$attribute->format()->name().'<br />';
                        if ($attribute->vocabulary()) {
                            $contents2 .= '------------ '.$attribute->vocabulary()->concept().'<br />';
                        }
                    }
                }
            }
        }

        if ($vocabs = ORM::findAll(Vocabulary::class)) {
            $contents2 .= '<br /><br />Vocabularies<br /><br />';
            foreach ($vocabs as $vocab) {
                $contents2 .= $vocab->concept().'   '.$vocab->keyword().'<br />';
                foreach ($vocab->terms() as $term) {
                    $contents2 .= '---- '.$term->name().'   '.$term->alias().'<br />';
                    foreach ($term->parameters() as $parm) {
                        $contents2 .= '-------- '.$parm->name().'   '.$parm->value().'<br />';
                    }
                }
            }
        }

        $content[0] = $contents;
        $content[1] = $contents2;
        $options['page_config'] = [
            "navlinks" => [
                ["name" => "dime.home", "dropdown" => false, "target" => "home"],
                ["name" => "dime.about", "dropdown" => false, "target" => "about"],
                ["name" => "dime.treasure", "dropdown" => false, "target" => "treasure"],
                ["name" => "dime.research", "dropdown" => false, "target" => "research"],
                ["name" => "dime.background", "dropdown" => false, "target" => "background"],
            ],
            "sidelinks" => [
                [
                    "name" => "add",
                    "active" => false,
                    "role" => "IS_AUTHENTICATED_ANONYMOUSLY",
                    "links" => [
                        ["name" => "dime.find.add", "active" => false, "target" => "finds.add"],
                        ["name" => "dime.location.add", "active" => false, "target" => "locations.add"],
                    ],
                ],
                [
                    "name" => "search",
                    "active" => false,
                    "role" => "IS_AUTHENTICATED_ANONYMOUSLY",
                    "links" => [
                        ["name" => "dime.find.list", "active" => false, "target" => "finds.list"],
                        ["name" => "dime.location.list", "active" => false, "target" => "locations.list"],
                    ],
                ],
            ]
        ];

        return Service::render('pages/page.html.twig', ['content' => $content]);
    }
}
