<?php

/**
 * Silex User Provider
 *
 *  Copyright 2016 by Simon Erhardt <hello@rootlogin.ch>
 *
 * This file is part of the silex user provider.
 *
 * The silex user provider is free software: you can redistribute
 * it and/or modify it under the terms of the Lesser GNU General Public
 * License version 3 as published by the Free Software Foundation.
 *
 * The silex user provider is distributed in the hope that it will
 * be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the Lesser GNU General Public
 * License along with the silex user provider.  If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * @license LGPL-3.0 <http://spdx.org/licenses/LGPL-3.0>
 */

namespace rootLogin\UserProvider\Controller;

use rootLogin\UserProvider\Entity\User;
use rootLogin\UserProvider\Form\Model\PasswordChange;
use rootLogin\UserProvider\Form\Model\PasswordForgotten;
use rootLogin\UserProvider\Form\Model\PasswordReset;
use rootLogin\UserProvider\Form\Type\RegisterType;
use rootLogin\UserProvider\Form\Type\EditType;
use rootLogin\UserProvider\Form\Type\ChangePasswordType;
use rootLogin\UserProvider\Form\Type\ForgotPasswordType;
use rootLogin\UserProvider\Form\Type\ResetPasswordType;
use rootLogin\UserProvider\Interfaces\UserManagerInterface;
use Silex\Application;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\DisabledException;
use InvalidArgumentException;
use JasonGrimes\Paginator;
use Symfony\Component\Translation\TranslatorInterface;

class UserListController
{
    public function listAction(Application $app, Request $request)
    {
        $order_by = $request->get('order_by') ?: 'name';
        $order_dir = $request->get('order_dir') == 'DESC' ? 'DESC' : 'ASC';
        $limit = (int)($request->get('limit') ?: 50);
        $page = (int)($request->get('page') ?: 1);
        $offset = ($page - 1) * $limit;

        $criteria = array();
        if (!$app['security.authorization_checker']->isGranted('ROLE_ADMIN')) {
            $criteria['isEnabled'] = true;
        }

        $users = $this->userManager->findBy($criteria, array($order_by => $order_dir), $limit, $offset);

        $numResults = $this->userManager->findCount($criteria);

        $paginator = new Paginator($numResults, $limit, $page,
            $app['url_generator']->generate('user.list') . '?page=(:num)&limit=' . $limit . '&order_by=' . $order_by . '&order_dir=' . $order_dir
        );

        foreach ($users as $user) {
            $user->imageUrl = $this->getGravatarUrl($user->getEmail(), 40);
        }

        // if ?_fragment is set, then show the fragment template
        $template = $request->get('_fragment') !== null ? $this->getTemplate('fragment-layout') : $this->getTemplate('layout');
        return $app['twig']->render($this->getTemplate('list'), [
            'layout_template' => $template,
            'users' => $users,
            'paginator' => $paginator,

            // The following variables are no longer used in the default template,
            // but are retained for backward compatibility.
            'numResults' => $paginator->getTotalItems(),
            'nextUrl' => $paginator->getNextUrl(),
            'prevUrl' => $paginator->getPrevUrl(),
            'firstResult' => $paginator->getCurrentPageFirstItem(),
            'lastResult' => $paginator->getCurrentPageLastItem(),
        ]);
    }
}
