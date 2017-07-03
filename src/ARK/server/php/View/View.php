<?php

/**
 * ARK Security
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

namespace ARK\View;

use ARK\Error\Error;
use ARK\Error\ErrorException;
use ARK\Framework\Application;
use ARK\Service;
use ARK\View\Layout;
use ARK\ORM\ORM;
use Symfony\Component\HttpFoundation\Response;

class View
{
    protected $app = null;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function templates()
    {
        return $this->app['twig'];
    }

    public function layout($name)
    {
        $layout =  ORM::find(Layout::class, $name);
        if ($layout) {
            return $layout;
        }
        throw new ErrorException(new Error('INVALID_LAYOUT_NAME', "Invalid Layout Name: $name", "Layout $name does not exist"));
    }

    public function renderResponse($view, array $parameters = [], Response $response = null)
    {
        return $this->app->render($view, $parameters, $response);
    }

    public function renderView($view, array $parameters = [])
    {
        return $this->app->renderView($view, $parameters);
    }

    public function renderPdfResponse($view, array $parameters = [], $filename = 'file.pdf', Response $response = null)
    {
        $pdf = $this->renderPdf($view, $parameters);
        $headers = ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'filename="'.$filename.'"'];
        if ($response === null) {
            return new Response($pdf, 200, $headers);
        }
        $response->headers->add($headers);
        $response->setContent($pdf);
        return $response;
    }

    public function renderPdf($view, array $parameters = [])
    {
        $html = $this->renderView($view, $parameters);
        return $this->app['renderer.pdf']->getOutputFromHtml($html);
    }

    public function generatePdf($view, $path, array $parameters = [])
    {
        $html = $this->renderView($view, $parameters);
        $this->app['renderer.pdf']->generateFromHtml($html, $path);
    }

    public function renderImageResponse($view, array $parameters = [], $filename = 'image.jpg', Response $response = null)
    {
        $pdf = $this->renderImage($view, $parameters);
        $headers = ['Content-Type' => 'image/jpg', 'Content-Disposition' => 'filename="'.$filename.'"'];
        if ($response === null) {
            return new Response($pdf, 200, $headers);
        }
        $response->headers->add($headers);
        $response->setContent($pdf);
        return $response;
    }

    public function renderImage($view, array $parameters = [])
    {
        $html = $this->renderView($view, $parameters);
        return $this->app['renderer.image']->getOutputFromHtml($html);
    }

    public function generateImage($view, $path, array $parameters = [])
    {
        $html = $this->renderView($view, $parameters);
        $this->app['renderer.image']->generateFromHtml($html, $path);
    }

    public function flashes()
    {
        Service::session()->getFlashBag();
    }

    public function clearFlashes()
    {
        Service::session()->getFlashBag()->clear();
    }

    public function loadFlashes()
    {
        $flashes =  ORM::findAll(Flash::class);
        foreach ($flashes as $flash) {
            $this->addFlash($flash->type(), $flash->keyword());
        }
    }

    public function addFlash($type, $message)
    {
        Service::session()->getFlashBag()->add($type, $message);
    }

    public function addSuccessFlash($message)
    {
        $this->addFlash('success', $message);
    }

    public function addErrorFlash($message)
    {
        $this->addFlash('error', $message);
    }

    public function addDangerFlash($message)
    {
        $this->addFlash('danger', $message);
    }

    public function addWarningFlash($message)
    {
        $this->addFlash('warning', $message);
    }

    public function addInfoFlash($message)
    {
        $this->addFlash('info', $message);
    }
}
