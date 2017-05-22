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

class PasswordResetController
{
    public function forgotPasswordAction(Application $app, Request $request)
    {
        if (!$this->isPasswordResetEnabled()) {
            throw new NotFoundHttpException($this->trans('Password resetting is not enabled.'));
        }

        $forgotPasswordForm = $this->formFactory->createBuilder($this->forms['forgot_password'], new PasswordForgotten());
        $forgotPasswordForm = $forgotPasswordForm->getForm();

        $forgotPasswordForm->handleRequest($request);

        if ($forgotPasswordForm->isValid()) {
            /** @var PasswordForgotten $passwordForgotten */
            $passwordForgotten = $forgotPasswordForm->getData();

            $user = $this->userManager->findOneBy(['email' => $passwordForgotten->getEmail()]);
            if ($user) {
                // Initialize and send the password reset request.
                $user->setTimePasswordResetRequested(new \DateTime());
                if (!$user->getConfirmationToken()) {
                    $user->setConfirmationToken($app['user.tokenGenerator']->generateToken());
                }
                $this->userManager->save($user);

                $app['user.mailer']->sendResetMessage($user);
                $app['session']->getFlashBag()->set('alert', $this->trans('Instructions for resetting your password have been emailed to you.'));

                return $app->redirect($app['url_generator']->generate('user.login'));
            }

            // This should not happen, because the form gets validated by the EMailExists validator.
            $msg = 'Internal error: User was not found.';
            $app['session']->getFlashBag()->set('alert', $msg);
        }

        // if ?_fragment is set, then show the fragment template
        $template = $request->get('_fragment') !== null ? $this->getTemplate('fragment-layout') : $this->getTemplate('layout');
        return $app['twig']->render($this->getTemplate('forgot-password'), [
            'layout_template' => $template,
            'forgotPasswordForm' => $forgotPasswordForm->createView(),
            'fromAddress' => $app['user.mailer']->getFromAddress()
        ]);
    }

    public function resetPasswordAction(Application $app, Request $request, $token)
    {
        if (!$this->isPasswordResetEnabled()) {
            throw new NotFoundHttpException($this->trans('Password resetting is not enabled.'));
        }

        $tokenExpired = false;

        $user = $this->userManager->findOneBy(['confirmationToken' => $token]);
        if ($user === null || $user->isPasswordResetRequestExpired($app['user.options']['passwordReset']['tokenTTL'])) {
            $tokenExpired = true;
        }

        if ($tokenExpired) {
            $app['session']->getFlashBag()->set('alert', $this->trans('Sorry, your password reset link has expired.'));
            return $app->redirect($app['url_generator']->generate('user.login'));
        }

        $resetPasswordForm = $this->formFactory->createBuilder($this->forms['reset_password'], new PasswordReset());
        $resetPasswordForm = $resetPasswordForm->getForm();

        $resetPasswordForm->handleRequest($request);
        if ($resetPasswordForm->isValid()) {
            /** @var PasswordReset $passwordReset */
            $passwordReset = $resetPasswordForm->getData();

            $this->userManager->setUserPassword($user, $passwordReset->getNewPassword());
            $user->setConfirmationToken(null);
            $user->setEnabled(true);
            $this->userManager->save($user);

            $this->userManager->loginAsUser($user);

            $app['session']->getFlashBag()->set('alert', $this->trans('Your password has been reset and you are now signed in.'));

            return $app->redirect($app['url_generator']->generate('user'));
        }

        // if ?_fragment is set, then show the fragment template
        $template = $request->get('_fragment') !== null ? $this->getTemplate('fragment-layout') : $this->getTemplate('layout');
        return $app['twig']->render($this->getTemplate('reset-password'), [
            'layout_template' => $template,
            'resetPasswordForm' => $resetPasswordForm->createView(),
            'user' => $user
        ]);
    }
}
