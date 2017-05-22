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

namespace ARK\Security\User\Controller;

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

class UserViewController
{
    public function viewAction(Application $app, Request $request, $id)
    {
        $user = $this->userManager->getUser($id);

        if (!$user) {
            throw new NotFoundHttpException($this->trans('No user was found with that ID.'));
        }

        if (!$user->isEnabled() && !$app['security.authorization_checker']->isGranted('ROLE_ADMIN')) {
            throw new NotFoundHttpException($this->trans('That user is disabled (pending email confirmation).'));
        }

        // if ?_fragment is set, then show the fragment template
        $template = $request->get('_fragment') !== null ? $this->getTemplate('fragment-layout') : $this->getTemplate('layout');
        return $app['twig']->render($this->getTemplate('view'), [
            'layout_template' => $template,
            'user' => $user,
            'imageUrl' => $this->getGravatarUrl($user->getEmail()),
        ]);
    }

    public function viewSelfAction(Application $app, Request $request)
    {
        $id = $app['user']->getId();

        return $this->viewAction($app, $request, $id);
    }

    public function editAction(Application $app, Request $request, $id)
    {
        $user = $this->userManager->getUser($id);
        if (!$user) {
            throw new NotFoundHttpException($this->trans('No user was found with that ID.'));
        }

        $editForm = $this->formFactory->createBuilder($this->forms['edit'], $user);
        $editForm = $editForm->getForm();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            /** @var User $user */
            $user = $editForm->getData();

            $this->userManager->save($user);

            $msg = $this->trans('Saved account information.');
            $app['session']->getFlashBag()->set('alert', $msg);
        }

        // if ?_fragment is set, then show the fragment template
        $template = $request->get('_fragment') !== null ? $this->getTemplate('fragment-layout') : $this->getTemplate('layout');
        return $app['twig']->render($this->getTemplate('edit'), [
            'layout_template' => $template,
            'editForm' => $editForm->createView(),
            'user' => $user
        ]);
    }

    public function editSelfAction(Application $app, Request $request)
    {
        $id = $app['user']->getId();

        return $this->editAction($app, $request, $id);
    }
}
