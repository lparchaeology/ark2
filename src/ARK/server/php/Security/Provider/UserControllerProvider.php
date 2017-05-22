<?php
/**
 * Created by PhpStorm.
 * User: simu
 * Date: 10.02.16
 * Time: 10:18
 */

namespace ARK\Security\User\Provider;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\ServiceControllerResolver;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserProviderControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/user/login', 'UserLoginController')
            ->bind('user.login');

        $controllers->match('/user/register', 'UserResetContoller')
            ->method('GET|POST')
            ->bind('user.register');

        $controllers->match('/user/confirm', 'UserResetContoller')
            ->method('GET|POST')
            ->bind('user.confirm');

        $controllers->match('/user/reset', 'UserResetContoller')
            ->method('GET|POST')
            ->bind('user.reset');

        $controllers->match('/user/check', function (){})
            ->method('GET|POST')
            ->bind('user.check');

        $controllers->match('/user/logout', function (){})
            ->method('GET')
            ->bind('user.logout');

        return $controllers;
    }
}
