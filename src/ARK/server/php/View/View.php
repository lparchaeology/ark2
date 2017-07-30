<?php

/**
 * ARK Security.
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

namespace ARK\View;

use ARK\Error\Error;
use ARK\Error\ErrorException;
use ARK\Framework\Application;
use ARK\ORM\ORM;
use ARK\Service;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

class View
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function templates() : Twig_Environment
    {
        return $this->app['twig'];
    }

    public function layout(string $name) : Layout
    {
        $layout = ORM::find(Layout::class, $name);
        if ($layout) {
            return $layout;
        }
        throw new ErrorException(
            new Error('INVALID_LAYOUT_NAME', "Invalid Layout Name: $name", "Layout $name does not exist")
        );
    }

    public function renderResponse(string $view, iterable $parameters = [], Response $response = null) : Response
    {
        return $this->app->render($view, $parameters, $response);
    }

    public function renderView(string $view, iterable $parameters = []) : string
    {
        return $this->app->renderView($view, $parameters);
    }

    public function renderPdfResponse(
        string $view,
        iterable $parameters = [],
        string $filename = 'file.pdf',
        Response $response = null
    ) : Response {
        $pdf = $this->renderPdf($view, $parameters);
        $headers = ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'filename="'.$filename.'"'];
        if ($response === null) {
            return new Response($pdf, 200, $headers);
        }
        $response->headers->add($headers);
        $response->setContent($pdf);
        return $response;
    }

    public function renderPdf(string $view, iterable $parameters = []) : string
    {
        $html = $this->renderView($view, $parameters);
        return $this->app['renderer.pdf']->getOutputFromHtml($html);
    }

    public function generatePdf(string $view, string $path, iterable $parameters = []) : void
    {
        $html = $this->renderView($view, $parameters);
        $this->app['renderer.pdf']->generateFromHtml($html, $path);
    }

    public function renderImageResponse(
        string $view,
        iterable $parameters = [],
        string $filename = 'image.jpg',
        Response $response = null
    ) : Response {
        $pdf = $this->renderImage($view, $parameters);
        $headers = ['Content-Type' => 'image/jpg', 'Content-Disposition' => 'filename="'.$filename.'"'];
        if ($response === null) {
            return new Response($pdf, 200, $headers);
        }
        $response->headers->add($headers);
        $response->setContent($pdf);
        return $response;
    }

    public function renderImage(string $view, iterable $parameters = []) : string
    {
        $html = $this->renderView($view, $parameters);
        return $this->app['renderer.image']->getOutputFromHtml($html);
    }

    public function generateImage(string $view, string $path, iterable $parameters = []) : void
    {
        $html = $this->renderView($view, $parameters);
        $this->app['renderer.image']->generateFromHtml($html, $path);
    }

    public function flashes() : void
    {
        Service::session()->getFlashBag();
    }

    public function clearFlashes() : void
    {
        Service::session()->getFlashBag()->clear();
    }

    public function loadFlashes() : void
    {
        $flashes = ORM::findAll(Flash::class);
        foreach ($flashes as $flash) {
            $this->addFlash($flash->type(), $flash->keyword());
        }
    }

    public function addFlash(string $type, string $message) : void
    {
        Service::session()->getFlashBag()->add($type, $message);
    }

    public function addSuccessFlash(string $message) : void
    {
        $this->addFlash('success', $message);
    }

    public function addErrorFlash(string $message) : void
    {
        $this->addFlash('error', $message);
    }

    public function addDangerFlash(string $message) : void
    {
        $this->addFlash('danger', $message);
    }

    public function addWarningFlash(string $message) : void
    {
        $this->addFlash('warning', $message);
    }

    public function addInfoFlash(string $message) : void
    {
        $this->addFlash('info', $message);
    }
}
