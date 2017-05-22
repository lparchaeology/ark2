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

use ARK\Service;
use Symfony\Component\HttpFoundation\Request;

class UserRegisterController
{
    public function __invoke(Request $request)
    {
        $registerForm = $this->formFactory->createBuilder($this->forms['register'], $this->userManager->getEmptyUser());
        $registerForm = $registerForm->getForm();

        $registerForm->handleRequest($request);

        if ($registerForm->isValid()) {
            $user = $registerForm->getData();
            Service::security()->userProvider()->registerUser($username, $email, $plainPassword);
            Service::addAlertFlash('core.user.created.flash');
            if (Service::security()->isLoggedIn()) {
                return $app->redirect($app['url_generator']->generate('user.view', ['id' => $user->getId()]));
            }
            return $app['twig']->render($this->getTemplate('register-confirmation-sent'), [
                'layout_template' => $this->getTemplate('layout'),
                'email' => $user->getEmail(),
            ]);
        }

        $template = $request->get('_fragment') !== null ? $this->getTemplate('fragment-layout') : $this->getTemplate('layout');
        return $app['twig']->render($this->getTemplate('register'), [
            'layout_template' => $template,
            'registerForm' => $registerForm->createView()
        ]);
    }
}
