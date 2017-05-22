<?php
/**
 * Created by PhpStorm.
 * User: simu
 * Date: 10.02.16
 * Time: 10:18
 */

namespace ARK\Security\User\Provider;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class AdminControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->match('/admin/users/{id}', 'UserViewController')
            ->method('GET|POST')
            ->bind('admin.user.edit');

        $controllers->match('/admin/users', 'UserListController')
            ->method('GET|POST')
            ->bind('admin.user.list');

        return $controllers;
    }
}
