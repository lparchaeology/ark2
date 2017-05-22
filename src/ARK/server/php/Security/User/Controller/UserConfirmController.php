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

class UserConfirmController
{
    public function __invoke(Request $request, $token)
    {
        $user = $this->userManager->findOneBy(['confirmationToken' => $token]);
        if (!$user) {
            $app['session']->getFlashBag()->set('alert', $this->trans('Sorry, your email confirmation link has expired.'));

            return $app->redirect($app['url_generator']->generate('user.login'));
        }

        $user->setConfirmationToken(null);
        $user->setEnabled(true);
        $this->userManager->save($user);

        $app['session']->getFlashBag()->set('alert', $this->trans('Thank you! Your account has been activated.'));

        return $app->redirect($app['url_generator']->generate('user.view', ['id' => $user->getId()]));
    }

    public function resendConfirmationAction(Application $app, Request $request)
    {
        $email = $request->request->get('email');
        $user = $this->userManager->findOneBy(['email' => $email]);
        if (!$user) {
            throw new NotFoundHttpException($this->trans('No user account was found with that email address.'));
        }

        if (!$user->getConfirmationToken()) {
            $user->setConfirmationToken($app['user.tokenGenerator']->generateToken());
            $this->userManager->save($user);
        }

        $app['user.mailer']->sendConfirmationMessage($user);

        // Render the "go check your email" page.
        // if ?_fragment is set, then show the fragment template
        $template = $request->get('_fragment') !== null ? $this->getTemplate('fragment-layout') : $this->getTemplate('layout');
        return $app['twig']->render($this->getTemplate('register-confirmation-sent'), [
            'layout_template' => $template,
            'email' => $user->getEmail(),
        ]);
    }
}
