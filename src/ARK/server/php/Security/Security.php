<?php

/**
 * ARK Security
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
 * @php        >=5.6, >=7.0
 */

namespace ARK\Security;

use ARK\Actor\Actor;
use ARK\Application;
use ARK\Error\ErrorException;
use ARK\Model\Attribute;
use ARK\Model\Item;
use ARK\ORM\ORM;
use ARK\Security\User;
use ARK\Service;
use ARK\Vocabulary\Term;
use ARK\Workflow\Security\ActorRole;
use ARK\Workflow\Security\ActorUser;
use ARK\Workflow\Role;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class Security
{
    protected $app = null;
    protected $options = null;
    protected $anon = null;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->options = $app['user.options'];
    }

    public function credentials($key)
    {
        try {
            $path = Service::configDir() . '/credentials.json';
            $credentials = json_decode(file_get_contents($path), true);
            if (isset($credentials[$key])) {
                return $credentials[$key];
            }
        } catch (Exception $e) {
            // Nothing to see here, move along now...
            dump('exception');
        }
        return null;
    }

    public function tokenStorage()
    {
        return $this->app['security.token_storage'];
    }

    public function userProvider()
    {
        return $this->app['user.provider'];
    }

    public function lastError(Request $request)
    {
        return $this->app['security.last_error']($request);
    }

    public function lastUsername()
    {
        return Service::session()->get('_security.last_username');
    }

    public function user()
    {
        if ($token = $this->tokenStorage()->getToken()) {
            if (!$token instanceof AnonymousToken) {
                return $token->getUser();
            }
        }
        if ($this->anon === null) {
            $this->anon = new User('anonymous');
            $this->anon->enable();
        }
        return $this->anon;
    }

    public function isLoggedIn()
    {
        if ($token = $this->tokenStorage()->getToken()) {
            return $this->isGranted('IS_AUTHENTICATED_REMEMBERED');
        }
        return false;
    }

    public function isGranted($permission)
    {
        return $this->app['security.authorization_checker']->isGranted($permission);
    }

    public function generateToken()
    {
        return base64_encode(random_bytes(32));
    }

    protected function encoder()
    {
        return $this->app['security.encoder.bcrypt'];
    }

    public function encodePassword($plainPassword, $salt = null)
    {
        return $this->encoder()->encodePassword($plainPassword, $salt);
    }

    public function checkPassword(User $user, $plainPassword)
    {
        return $this->encoder()->isPasswordValid($user->password(), $plainPassword, $user->getSalt());
    }

    public function validatePassword($plainPassword)
    {
        $errors = $this->app['password.validate']->validate($plainPassword, $this->app['password.validator.constraint']);
        if (count($errors) > 0) {
            throw ErrorException();
        }
        return true;
    }

    public function validate(User $user)
    {
        $errors = $user->validate();

        // Ensure email address is unique.
        $duplicates = $this->findBy(array('email' => $user->getEmail()));
        if (!empty($duplicates)) {
            foreach ($duplicates as $dup) {
                if ($user->getId() && $dup->getId() == $user->getId()) {
                    continue;
                }
                $errors['email'] = 'An account with that email address already exists.';
            }
        }

        // Ensure username is unique or null.
        if ($user->hasRealUsername()) {
            $duplicates = $this->findBy(array('username' => $user->getRealUsername()));
            if (!empty($duplicates)) {
                foreach ($duplicates as $dup) {
                    if ($user->getId() && $dup->getId() == $user->getId()) {
                        continue;
                    }
                    $errors['username'] = 'An account with that username already exists.';
                }
            }
        }

        // If username is required, ensure it is set.
        if ($this->isUsernameRequired && !$user->getRealUsername()) {
            $errors['username'] = 'Username is required.';
        }

        return $errors;
    }

    public function loginAsUser(User $user)
    {
        if (null !== ($current_token = $this->tokenStorage()->getToken())) {
            $providerKey = method_exists($current_token, 'getProviderKey') ? $current_token->getProviderKey() : $current_token->getSecret();
            $token = new UsernamePasswordToken($user, null, $providerKey);
            $this->tokenStorage()->setToken($token);
            $this->app['user'] = $user;
        }
    }

    public function registerUser(User $user, Actor $actor = null, Role $role = null)
    {
        if (!$this->options['adminConfirm']) {
            $user->confirm();
        }
        if ($this->options['verifyEmail']) {
            $user->setVerificationRequested();
        } else {
            $user->verify();
        }
        $user->enable();
        ORM::persist($user);
        if ($actor && $role) {
            $actorUser = new ActorUser($actor, $user);
            $actorRole = new ActorRole($actor, $role);
            ORM::persist($actor);
            ORM::persist($actorUser);
            ORM::persist($actorRole);
            ORM::flush($actor);
        }
        ORM::flush($user);
        if ($this->options['verifyEmail']) {
            //$this->sendVerificationMessage($user);
        }
    }

    public function createUser($username, $email, $plainPassword, $name = null, $level = 'ROLE_USER')
    {
        $user = new User($username, $username, $email);
        $user->setPassword($plainPassword);
        $user->setName($name);
        $user->setLevel($level);
        return $user;
    }

    public function resetUser(User $user)
    {
        $user->expireCredentials();
        //$this->sendResetMessage($user);
    }

    protected function getGravatarUrl($email, $size = 80)
    {
        // See https://en.gravatar.com/site/implement/images/ for available options.
        return '//www.gravatar.com/avatar/' . md5(strtolower(trim($email))) . '?s=' . $size . '&d=identicon';
    }

    public function sendVerificationMessage(User $user)
    {
        $url = Service::url('user.confirm', ['token' => $user->getVerificationToken()]);

        $context = [
            'user' => $user,
            'confirmationUrl' => $url
        ];

        $this->sendMessage($this->confirmationTemplate, $context, $this->getFromEmail(), $user->getEmail());
    }

    public function sendResetMessage(User $user)
    {
        $url = $this->urlGenerator->generate('user.reset', array('token' => $user->getConfirmationToken()), UrlGeneratorInterface::ABSOLUTE_URL);

        $context = [
            'user' => $user,
            'resetUrl' => $url
        ];

        $this->sendMessage($this->resetTemplate, $context, $this->getFromEmail(), $user->getEmail());
    }

    protected function sendMessage($templateName, $context, $fromEmail, $toEmail)
    {
        if ($this->noSend) {
            return;
        }

        $context = $this->twig->mergeGlobals($context);
        $template = $this->twig->loadTemplate($templateName);
        $subject = $template->renderBlock('subject', $context);
        $textBody = $template->renderBlock('body_text', $context);
        $htmlBody = $template->renderBlock('body_html', $context);

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail);

        if (!empty($htmlBody)) {
            $message->setBody($htmlBody, 'text/html')
                ->addPart($textBody, 'text/plain');
        } else {
            $message->setBody($textBody);
        }

        $this->mailer->send($message);
    }

    public function hasVisibility($user, $model)
    {
        if ($model instanceof Item) {
            // Do something to check User/Actor can see Item
        }
        if ($model instanceof Attribute) {
            // Do something to check User/Actor can see Attribute
        }
        return true;
    }
}
