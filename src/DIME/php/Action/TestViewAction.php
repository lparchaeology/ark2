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

use ARK\Translation\Key;
use ARK\Service;
use Symfony\Component\HttpFoundation\Request;

class TestViewAction
{
    public function __invoke(Request $request)
    {
        $contents = Service::translate('site.welcome');

        if ($finds = Service::repository('DIME\\Entity\\Find')->findAll()) {
            $contents .= '<br /><br />Finds<br /><br />';
            foreach ($finds as $find) {
                $contents .= $find->id().'   '.$find->name().'   '.$find->schema()->name().'<br />';
                foreach ($find->properties() as $key => $value) {
                    if (is_array($value)) {
                        $contents .= '---- '.$key.' = ['.$value[0].']  '.$value[1].'<br />';
                    } else {
                        $contents .= '---- '.$key.' = '.$value.'<br />';
                    }
                }
            }
        }

        if ($actors = Service::repository('ARK\\Entity\\Actor')->findAll()) {
            $contents .= '<br /><br />Actors<br /><br />';
            foreach ($actors as $actor) {
                $contents .= $actor->id().'   '.$actor->name().'   '.$actor->schema()->name().'<br />';
            }
        }

        if ($modules = Service::repository('ARK\\Schema\\Module')->findAll()) {
            $contents .= '<br /><br />Modules<br /><br />';
            foreach ($modules as $module) {
                $contents .= $module->name().'   '.$module->resource().'<br />';
                foreach ($module->schemas() as $schema) {
                    $contents .= '---- '.$schema->name().'   '.$schema->module()->entity().'<br />';
                    foreach ($schema->subtypes() as $subtype) {
                        $contents .= '-------- '.$subtype->name().'   '.$subtype->entity().'<br />';
                        foreach ($schema->attributes($subtype->name()) as $attribute) {
                            $contents .= '------------ '.$attribute->name().'   '.$attribute->format()->name().'<br />';
                        }
                        foreach ($schema->associations($subtype->name()) as $association) {
                            $contents .= '------------ '.$association->name().'   '.$association->inverseSchema()->name().'<br />';
                        }
                    }
                    if (!$schema->useSubtypes()) {
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

        if ($trans = Service::repository(Key::class)->findAll()) {
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

        if ($formats = Service::repository('ARK\\Schema\\Format')->findAll()) {
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

        if ($vocabs = Service::repository('ARK\\Vocabulary\\Vocabulary')->findAll()) {
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

        return Service::render('pages/page.html.twig', array('contents' => $contents, 'contents2' => $contents2));
    }
}
