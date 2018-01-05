<?php

/**
 * ARK View Service Provider.
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

namespace ARK\Framework\Provider;

use ARK\ARK;
use ARK\Service;
use ARK\Twig\Extension\TranslateExtension;
use ARK\View\ViewService;
use Knp\Snappy\Image;
use Knp\Snappy\Pdf;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Symfony\Bridge\Twig\Extension\HttpKernelRuntime;
use Symfony\Component\Form\FormRenderer;
use Twig_Extensions_Extension_Date;
use Twig_Extensions_Extension_Intl;
use Twig_Function;

class ViewServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container) : void
    {
        // ARK View Service
        $container['view'] = function ($app) {
            return new ViewService($app);
        };

        // Enable the Assets
        $container['path.assets'] = '/assets/'.$container['ark']['view']['frontend'];
        $container->register(
            new AssetServiceProvider(),
            [
                'assets.version' => ARK::version(),
                'assets.version_format' => '%s?version=%s',
                'assets.named_packages' => [
                    'frontend' => [
                        'base_path' => $container['path.assets'],
                    ],
                ],
            ]
        );

        // Enable templates
        $container->register(new TwigServiceProvider());
        $container->extend('twig', function ($twig, $app) {
            $twig->addExtension(new Twig_Extensions_Extension_Intl());
            $twig->addExtension(new Twig_Extensions_Extension_Date($app['translator']));
            $twig->addExtension(new TranslateExtension($app['translator']));
            $twig->addFunction(new Twig_Function('imagePath', Service::class.'::imagePath'));
            $twig->addGlobal('security', $app['security']);
            $twig->addGlobal('workflow', $app['workflow']);
            return $twig;
        });
        $container->extend('twig.runtimes', function ($twig, $app) {
            return [
                HttpKernelRuntime::class => 'twig.runtime.httpkernel',
                FormRenderer::class => 'twig.form.renderer',
            ];
        });
        $container['twig.path'] = [
            $container['dir.site'].'/templates/'.$container['ark']['view']['frontend'],
        ];
        $container['twig.form.templates'] = [
            'blocks/forms.html.twig',
        ];
        $container['twig.options'] = [
            'cache' => $container['dir.cache'].'/twig',
        ];

        // Enable render to PDF or Image
        $container['renderer.pdf.binary'] = $container['ark']['view']['renderer']['pdf'];
        $container['renderer.pdf.options'] = [];
        $container['renderer.pdf'] = function ($container) {
            $pdf = new Pdf($container['renderer.pdf.binary'], $container['renderer.pdf.options']);
            $pdf->setTemporaryFolder($container['dir.files'].'/tmp');
            return $pdf;
        };
        $container['renderer.image.binary'] = $container['ark']['view']['renderer']['image'];
        $container['renderer.image.options'] = [];
        $container['renderer.image'] = function ($container) {
            return new Image($container['renderer.image.binary'], $container['renderer.image.options']);
        };

        // Add RECAPTCHA config
        $container['recaptcha.locale_key'] = $container['ark']['view']['recaptcha']['locale_key'];
        $container['recaptcha.enabled'] = $container['ark']['view']['recaptcha']['enabled'];
        $container['recaptcha.verify_host'] = $container['ark']['view']['recaptcha']['verify_host'];
        $container['recaptcha.ajax'] = $container['ark']['view']['recaptcha']['ajax'];
    }
}
