<?php

/**
 * ARK Security.
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

namespace ARK\View;

use ARK\Error\Error;
use ARK\File\File;
use ARK\Framework\Application;
use ARK\Http\Exception\InternalServerHttpException;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Translation\Translation;
use League\Glide\Responses\SymfonyResponseFactory;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Twig_Environment;

class ViewService
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

    public function assets() : Packages
    {
        return $this->app['assets.packages'];
    }

    public function layout(string $name) : Layout
    {
        $layout = ORM::find(Layout::class, $name);
        if ($layout) {
            return $layout;
        }
        throw new InternalServerHttpException(
            'INVALID_LAYOUT_NAME',
            "Layout $name does not exist"
        );
    }

    public function renderResponse(string $template, iterable $context = [], Response $response = null) : Response
    {
        return $this->app->render($template, $context, $response);
    }

    public function renderView(string $template, iterable $context = []) : string
    {
        return $this->app->renderView($template, $context);
    }

    public function renderPdfResponse(
        string $template,
        iterable $context = [],
        string $filename = 'file.pdf',
        Response $response = null
    ) : Response {
        $pdf = $this->renderPdf($template, $context);
        $headers = ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'filename="'.$filename.'"'];
        if ($response === null) {
            return new Response($pdf, 200, $headers);
        }
        $response->headers->add($headers);
        $response->setContent($pdf);
        return $response;
    }

    public function renderPdf(string $template, iterable $context = [], iterable $options = []) : string
    {
        $html = $this->renderView($template, $context);
        return $this->app['renderer.pdf']->getOutputFromHtml($html, $options);
    }

    public function generatePdf(string $template, string $path, iterable $context = []) : void
    {
        $html = $this->renderView($template, $context);
        $this->app['renderer.pdf']->generateFromHtml($html, $path);
    }

    public function renderImageResponse(
        string $template,
        iterable $context = [],
        string $filename = 'image.jpg',
        Response $response = null
    ) : Response {
        $pdf = $this->renderImage($template, $context);
        $headers = ['Content-Type' => 'image/jpg', 'Content-Disposition' => 'filename="'.$filename.'"'];
        if ($response === null) {
            return new Response($pdf, 200, $headers);
        }
        $response->headers->add($headers);
        $response->setContent($pdf);
        return $response;
    }

    public function renderImage(string $template, iterable $context = []) : string
    {
        $html = $this->renderView($template, $context);
        return $this->app['renderer.image']->getOutputFromHtml($html);
    }

    public function generateImage(string $template, string $path, iterable $context = []) : void
    {
        $html = $this->renderView($template, $context);
        $this->app['renderer.image']->generateFromHtml($html, $path);
    }

    public function fileResponse(string $id, string $disposition = ResponseHeaderBag::DISPOSITION_ATTACHMENT) : Response
    {
        $file = ORM::find(File::class, $id);
        $factory = new SymfonyResponseFactory();
        $response = $factory->create(Service::filesystem(), $file->path());
        $response->headers->set('Content-Disposition', $response->headers->makeDisposition($disposition, $file->name()));
        return $response;
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

    public function addFlash(string $flash, string $message, iterable $parms = []) : void
    {
        $message = Translation::translate($message, $flash, $parms);
        Service::session()->getFlashBag()->add($flash, $message);
    }

    public function addSuccessFlash(string $message, iterable $parms = []) : void
    {
        $this->addFlash('success', $message, $parms);
    }

    public function addErrorFlash(string $message, iterable $parms = []) : void
    {
        $this->addFlash('error', $message, $parms);
    }

    public function addDangerFlash(string $message, iterable $parms = []) : void
    {
        $this->addFlash('danger', $message, $parms);
    }

    public function addWarningFlash(string $message, iterable $parms = []) : void
    {
        $this->addFlash('warning', $message, $parms);
    }

    public function addInfoFlash(string $message, iterable $parms = []) : void
    {
        $this->addFlash('info', $message, $parms);
    }
}
