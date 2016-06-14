<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Route/ApiControllerProvider.php
*
* Ark Route Site Controller Provider
*
* PHP versions 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Partnership Ltd.
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @package    ark
* @author     John Layt <j.layt@lparchaeology.com>
* @copyright  2016 L - P : Heritage LLP.
* @license    GPL-3.0+
* @see        http://ark.lparchaeology.com/code/src/php/Route/ApiControllerProvider.php
* @since      2.0
*/

namespace ARK\Translation\Profiler;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Translation\DataCollectorTranslator;
use Symfony\Component\Translation\DataCollector\TranslationDataCollector;

class TranslationProfilerServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {

        $app['data_collector.templates'] = $app->extend('data_collector.templates', function ($templates) {
            $templates[] = array('translation', '@WebProfiler/Collector/translation.html.twig');
            return $templates;
        });

        $app->extend('translator', function ($translator, $app) {
            $app['translator.data_collector'] = new DataCollectorTranslator($translator);
            return $app['translator.data_collector'];
        });

        $app->extend('data_collectors', function ($collectors, $app) {
            $collectors['translation'] = function ($app) { return new TranslationDataCollector($app['translator.data_collector']); };
            return $collectors;
        });

    }
}
