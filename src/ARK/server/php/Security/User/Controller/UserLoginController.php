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

class UserLoginController
{
    public function __invoke(Request $request)
    {
        $authException = $app['user.last_auth_exception']($request);

        if ($authException instanceof DisabledException) {
            // This exception is thrown if (!$user->isEnabled())
            // Warning: Be careful not to disclose any user information besides the email address at this point.
            // The Security system throws this exception before actually checking if the password was valid.
            $user = $this->userManager->refreshUser($authException->getUser());

            return $app['twig']->render($this->getTemplate('login-confirmation-needed'), [
                'layout_template' => $this->getTemplate('layout'),
                'email' => $user->getEmail(),
                'fromAddress' => $app['user.mailer']->getFromAddress(),
                'resendUrl' => $app['url_generator']->generate('user.resend-confirmation'),
            ]);
        }

        // if ?_fragment is set, then show the fragment template
        $template = $request->get('_fragment') !== null ? $this->getTemplate('fragment-layout') : $this->getTemplate('layout');
        return $app['twig']->render($this->getTemplate('login'), [
            'layout_template' => $template,
            'error' => $authException ? $this->trans($authException->getMessageKey()) : null,
            'last_username' => $app['session']->get('_security.last_username'),
            'allowRememberMe' => isset($app['security.remember_me.response_listener']),
            'allowPasswordReset' => $this->isPasswordResetEnabled(),
        ]);
    }
}
