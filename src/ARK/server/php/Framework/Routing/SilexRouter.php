<?php

/**
 * ARK Route Service Provider.
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

namespace ARK\Framework\Routing;

use Pimple\Container;
use Silex\Provider\Routing\RedirectableUrlMatcher;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouterInterface;

class SilexRouter implements RouterInterface
{
    protected $container;
    protected $context;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function setContext(RequestContext $context) : void
    {
        $this->context = $context;
    }

    public function getContext()
    {
        return $this->context ?: $this->container['request_context'];
    }

    public function getRouteCollection()
    {
        return $this->container['routes'];
    }

    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        $generator = new UrlGenerator($this->getRouteCollection(), $this->getContext(), $this->container['logger']);
        return $generator->generate($name, $parameters, $referenceType);
    }

    public function match($pathinfo)
    {
        $matcher = new RedirectableUrlMatcher($this->getRouteCollection(), $this->getContext());
        return $matcher->match($pathinfo);
    }
}
