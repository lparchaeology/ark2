<?php

/**
 * ARK Router.
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

namespace ARK\Routing;

use ARK\Service;
use Silex\Provider\Routing\RedirectableUrlMatcher;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouterInterface;

class Router implements RouterInterface
{
    protected $context;
    protected $generator;
    protected $matcher;

    public function setContext(RequestContext $context) : void
    {
        $this->context = $context;
    }

    public function getContext() : RequestContext
    {
        return $this->context ?: Service::context();
    }

    public function getRouteCollection() : iterable
    {
        return Service::routes();
    }

    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        if ($this->generator === null) {
            $this->generator = new UrlGenerator($this->getRouteCollection(), $this->getContext(), Service::logger());
        } else {
            $this->generator->setContext($this->getContext());
        }
        return $this->generator->generate($name, $parameters, $referenceType);
    }

    public function match($pathinfo)
    {
        if ($this->matcher === null) {
            $this->matcher = new RedirectableUrlMatcher($this->getRouteCollection(), $this->getContext());
        } else {
            $this->matcher->setContext($this->getContext());
        }
        return $this->matcher->match($pathinfo);
    }
}
