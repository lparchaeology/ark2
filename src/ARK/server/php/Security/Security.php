<?php

/**
 * ARK Security.
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

namespace ARK\Security;

use ARK\Actor\Actor;
use ARK\Error\ErrorException;
use ARK\Framework\Application;
use ARK\Model\Attribute;
use ARK\Model\Item;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Workflow\Role;
use ARK\Workflow\Security\ActorRole;
use ARK\Workflow\Security\ActorUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class Security
{
    protected $app;
    protected $options;
    protected $routes;
    protected $anon;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->options = $app['user.options'];
        $this->routes = $app['ark']['security']['routes'];
    }

    public static function credentials($key)
    {
        try {
            $path = Service::configDir().'/credentials.json';
            $credentials = json_decode(file_get_contents($path), true);
            if (isset($credentials[$key])) {
                return $credentials[$key];
            }
        } catch (Exception $e) {
            // Nothing to see here, move along now...
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
        $duplicates = $this->findBy(['email' => $user->getEmail()]);
        if (!empty($duplicates)) {
            foreach ($duplicates as $dup) {
                if ($user->getId() && $dup->getId() === $user->getId()) {
                    continue;
                }
                $errors['email'] = 'An account with that email address already exists.';
            }
        }

        // Ensure username is unique or null.
        if ($user->hasRealUsername()) {
            $duplicates = $this->findBy(['username' => $user->getRealUsername()]);
            if (!empty($duplicates)) {
                foreach ($duplicates as $dup) {
                    if ($user->getId() && $dup->getId() === $user->getId()) {
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

    public function loginAsUser(User $user, string $providerKey = 'secured', Request $request = null) : void
    {
        // TODO logout first?
        if (!$this->isLoggedIn()) {
            $token = new UsernamePasswordToken($user, null, $providerKey, $user->levels());
            $this->tokenStorage()->setToken($token);
            $this->app['user'] = $user;
            if ($request) {
                $request->getSession()->set('_security_'.$providerKey, serialize($token));
                //$event = new InteractiveLoginEvent($request, $token);
                //$this->app['dispatcher']->dispatch('security.interactive_login', $event);
            }
        }
    }

    public function registerUser(User $user, Actor $actor, \DateTime $expiry = null) : void
    {
        if ($expiry) {
            $user->expireAt($expiry);
        }
        $this->createActorUser($actor, $user, $expiry);
        $registeredBy = (Service::security()->isLoggedIn() ? Service::workflow()->actor() : $actor);
        Service::workflow()->apply($registeredBy, 'register', $actor);
        if ($this->options['verify_email']) {
            $user->setVerificationRequested();
        }
        if (!$this->options['verify_email_required'] && !$this->options['admin_confirm']) {
            $user->enable();
        }
        ORM::flush($actor);
        ORM::flush($user);
        if ($this->options['verify_email']) {
            $this->sendVerificationMessage($user);
        }
    }

    public function verifyUser(User $user) : void
    {
        if ($user->isVerificationRequestExpired($this->options['reset_ttl'])) {
            if ($this->options['verify_email']) {
                $user->setVerificationRequested();
                $this->sendVerificationMessage($user);
            }
        } else {
            $user->verify();
            if (!$this->options['admin_confirm']) {
                $user->enable();
            }
        }
        ORM::flush($user);
    }

    public function enableUser(User $user) : bool
    {
        if ($this->options['verify_email_required'] && !$user->isVerified()) {
            return false;
        }
        $user->enable();
        ORM::flush($user);
        return true;
    }

    public function createActorUser(Actor $actor, User $user, \DateTime $expiry = null) : ActorUser
    {
        $actorUser = new ActorUser($actor, $user);
        // TODO Always enable for now, need to think if any reason why you wouldn't?
        $actorUser->enable();
        $actorUser->expireAt($expiry);
        ORM::persist($actorUser);
        return $actorUser;
    }

    public function createActorRole(Actor $actor, Role $role = null, Actor $agentFor = null, \DateTime $expiry = null) : ActorRole
    {
        if (!$role) {
            $role = ORM::find(Role::class, $this->options['default_role']);
        }
        $actorRole = new ActorRole($actor, $role, $agentFor);
        // TODO Always enable for now, need to think if any reason why you wouldn't?
        $actorRole->enable();
        $actorRole->expireAt($expiry);
        ORM::persist($actorRole);
        return $actorRole;
    }

    public function createUser(
        string $username,
        string $email,
        string $plainPassword,
        string $name = null,
        string $level = 'ROLE_USER'
    ) : User {
        $user = new User($username, $username, $email);
        $user->setPassword($plainPassword);
        $user->setName($name);
        $user->setLevel($level);
        ORM::persist($user);
        return $user;
    }

    public function deleteUser(User $user) : void
    {
        $aus = ORM::findBy(ActorUser::class, ['user' => $user->id()]);
        ORM::remove($aus);
        ORM::flush($aus);
        ORM::remove($user);
        ORM::flush($user);
        $this->sendResetMessage($user);
    }

    public function requestPassword(User $user) : void
    {
        $user->setPasswordRequested();
        ORM::flush($user);
        $this->sendResetMessage($user);
    }

    public function resetPassword(User $user, $password) : void
    {
        if ($user->isPasswordRequestExpired($this->options['reset_ttl'])) {
            $this->requestPassword($user);
        } else {
            $user->setPassword($password);
            ORM::flush($user);
        }
    }

    public function hasVisibility($user, $model) : bool
    {
        if ($model instanceof Item) {
            // Do something to check User/Actor can see Item
        }
        if ($model instanceof Attribute) {
            // Do something to check User/Actor can see Attribute
        }
        return true;
    }

    public function encoder()
    {
        return $this->app['security.encoder.bcrypt'];
    }

    protected function sendVerificationMessage(User $user) : void
    {
        $url = Service::url($this->routes['confirm']['route'], ['token' => $user->verificationToken()]);
        $context = ['user' => $user, 'url' => $url];
        Service::sendEmail($this->options['email'], $user->email(), $this->options['verify_email_template'], $context);
    }

    protected function sendResetMessage(User $user) : void
    {
        $url = Service::url($this->routes['reset']['route'], ['token' => $user->passwordRequestToken()]);
        $context = ['user' => $user, 'url' => $url];
        Service::sendEmail($this->options['email'], $user->email(), $this->options['reset_email_template'], $context);
    }

    protected function getGravatarUrl(string $email, int $size = 80) : string
    {
        // See https://en.gravatar.com/site/implement/images/ for available options.
        return '//www.gravatar.com/avatar/'.md5(strtolower(trim($email))).'?s='.$size.'&d=identicon';
    }
}
