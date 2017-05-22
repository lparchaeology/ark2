<?php

namespace ARK\Security\User\Provider;

use ARK\Security\User\Provider\UserProvider;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\Voter\RoleHierarchyVoter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Translation\Loader\YamlFileLoader;

class UserProviderServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['user.options.default'] = [
            'mailer' => [
                'enabled' => true,
                'address' => 'do-not-reply@' . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : gethostname()),
                'sender' => null,
            ],
            'emailConfirmation' => false,
            'resetTokenTTL' => 86400,
            'roles' => [
                'ROLE_ANON' => 'This user has no privileges.',
                'ROLE_USER' => 'This user has registered user privileges.',
                'ROLE_ADMIN' => 'This user has administrator privileges.',
                'ROLE_SYSADMIN' => 'This user has system administrator privileges.',
            ],
        ];

        $app['user.options.init'] = $app->protect(function () use ($app) {
            $options = $app['user.options.default'];
            if (isset($app['user.options'])) {
                $options = array_replace_recursive($options, $app['user.options']);
            }
            $app['user.options'] = $options;
        });

        $app['user.provider'] = function ($app) {
            $app['user.options.init']();
            return new UserProvider($app);
        };

        $app['user.controller'] = function ($app) {
            $app['user.options.init']();

            $controller = new UserController($app['user.manager'], $app['form.factory'], $app['translator']);
            $controller->setEmailConfirmationRequired($app['user.options']['emailConfirmation']['required']);
            $controller->setTemplates($app['user.options']['templates']);
            $controller->setForms($app['user.options']['forms']);

            return $controller;
        };

        $app['user.mailer'] = function ($app) {
            $app['user.options.init']();

            $mailer = new Mailer($app['mailer'], $app['url_generator'], $app['twig']);
            $mailer->setFromAddress($app['user.options']['mailer']['fromEmail']['address'] ?: null);
            $mailer->setFromName($app['user.options']['mailer']['fromEmail']['name'] ?: null);
            $mailer->setConfirmationTemplate($app['user.options']['emailConfirmation']['template']);
            $mailer->setResetTemplate($app['user.options']['passwordReset']['template']);
            $mailer->setResetTokenTtl($app['user.options']['passwordReset']['tokenTTL']);
            if (!$app['user.options']['mailer']['enabled']) {
                $mailer->setNoSend(true);
            }

            return $mailer;
        };

        // Token generator.
        $app['user.tokenGenerator'] = function ($app) {
            return new TokenGenerator($app['logger']);
        };

        // Add a custom security voter to support testing user attributes.
        $app['security.voters'] = $app->extend('security.voters', function ($voters) use ($app) {
            foreach ($voters as $voter) {
                if ($voter instanceof RoleHierarchyVoter) {
                    $roleHierarchyVoter = $voter;
                    break;
                }
            }
            $voters[] = new EditUserVoter($roleHierarchyVoter);
            return $voters;
        });

        // Helper function to get the last authentication exception thrown for the given request.
        // It does the same thing as $app['security.last_error'](),
        // except it returns the whole exception instead of just $exception->getMessage()
        $app['user.last_auth_exception'] = $app->protect(function (Request $request) {
            if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
                return $request->attributes->get(Security::AUTHENTICATION_ERROR);
            }

            $session = $request->getSession();
            if ($session && $session->has(Security::AUTHENTICATION_ERROR)) {
                $exception = $session->get(Security::AUTHENTICATION_ERROR);
                $session->remove(Security::AUTHENTICATION_ERROR);

                return $exception;
            }
        });
    }
}
