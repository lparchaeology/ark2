<?php

namespace rootLogin\UserProvider\Provider;

use rootLogin\UserProvider\Command\UserRoleAddCommand;
use rootLogin\UserProvider\Command\UserRoleListCommand;
use rootLogin\UserProvider\Command\UserRoleRemoveCommand;
use rootLogin\UserProvider\Form\Type\ChangePasswordType;
use rootLogin\UserProvider\Form\Type\EditType;
use rootLogin\UserProvider\Form\Type\ForgotPasswordType;
use rootLogin\UserProvider\Form\Type\ResetPasswordType;
use rootLogin\UserProvider\Form\Type\UserRolesType;
use rootLogin\UserProvider\Validator\Constraints\EMailExistsValidator;
use rootLogin\UserProvider\Validator\Constraints\EMailIsUniqueValidator;
use rootLogin\UserProvider\Command\UserCreateCommand;
use rootLogin\UserProvider\Command\UserDeleteCommand;
use rootLogin\UserProvider\Command\UserListCommand;
use rootLogin\UserProvider\Controller\UserController;
use rootLogin\UserProvider\Form\Type\RegisterType;
use rootLogin\UserProvider\Form\Type\UserType;
use rootLogin\UserProvider\Lib\Mailer;
use rootLogin\UserProvider\Lib\TokenGenerator;
use rootLogin\UserProvider\Manager\DBALUserManager;
use rootLogin\UserProvider\Manager\OrmUserManager;
use rootLogin\UserProvider\Voter\EditUserVoter;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Silex\Api\BootableProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\Voter\RoleHierarchyVoter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use ARK\Security\User\Provider\UserProvider;

class UserProviderServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    /**
     * @var bool
     */
    protected $forceDBAL;

    public function __construct($forceDBAL = false)
    {
        $this->forceDBAL = $forceDBAL;
    }

    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app An Application instance
     */
    public function register(Container $app)
    {
        $this->setDefaultOptions($app);
        $this->initializeOptions($app);
        $this->initializeUserManager($app);
        $this->initializeUserController($app);
        $this->initializeMailer($app);
        $this->addValidators($app);
        $this->addFormTypes($app);

        // Token generator.
        $app['user.tokenGenerator'] = function ($app) {
            return new TokenGenerator($app['logger']);
        };

        // Current user.
        $app['user'] = function ($app) {
            return ($app['user.manager']->getCurrentUser());
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

        if (isset($app['translator'])) {
            $app['translator'] = $app->extend('translator', function ($translator, $app) {
                $translator->addResource('xliff', __DIR__ . '/../Resources/translations/messages.en.xliff', 'en', 'messages');
                $translator->addResource('xliff', __DIR__ . '/../Resources/translations/validators.en.xliff', 'en', 'validators');
                $translator->addResource('xliff', __DIR__ . '/../Resources/translations/mail.en.xliff', 'en', 'mail');
                $translator->addResource('xliff', __DIR__ . '/../Resources/translations/messages.de.xliff', 'de', 'messages');
                $translator->addResource('xliff', __DIR__ . '/../Resources/translations/validators.de.xliff', 'de', 'validators');
                $translator->addResource('xliff', __DIR__ . '/../Resources/translations/mail.de.xliff', 'de', 'mail');
                $translator->addResource('xliff', __DIR__ . '/../Resources/translations/messages.fr.xliff', 'fr', 'messages');
                $translator->addResource('xliff', __DIR__ . '/../Resources/translations/validators.fr.xliff', 'fr', 'validators');
                $translator->addResource('xliff', __DIR__ . '/../Resources/translations/mail.fr.xliff', 'fr', 'mail');
                $translator->addResource('xliff', __DIR__ . '/../Resources/translations/messages.it.xliff', 'it', 'messages');
                $translator->addResource('xliff', __DIR__ . '/../Resources/translations/validators.it.xliff', 'it', 'validators');
                $translator->addResource('xliff', __DIR__ . '/../Resources/translations/mail.it.xliff', 'it', 'mail');

                return $translator;
            });
        }

        // If symfony console is available, enable them
        if (isset($app['console.commands'])) {
            $app['console.commands'] = $app->extend('console.commands', function ($commands) use ($app) {
                $commands[] = new UserCreateCommand($app);
                $commands[] = new UserListCommand($app);
                $commands[] = new UserDeleteCommand($app);
                $commands[] = new UserRoleAddCommand($app);
                $commands[] = new UserRoleListCommand($app);
                $commands[] = new UserRoleRemoveCommand($app);

                return $commands;
            });
        }
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {
        // Add twig template path.
        if (isset($app['twig.loader.filesystem'])) {
            $app['twig.loader.filesystem']->addPath(__DIR__ . '/../Resources/views/', 'user');
        }

        // Validate the mailer configuration.
        $app['user.options.init']();
        try {
            /** @var Mailer $mailer */
            $mailer = $app['user.mailer'];
            $mailerExists = true;
        } catch (\RuntimeException $e) {
            $mailerExists = false;
            $mailerError = $e->getMessage();
        }
        if ($app['user.options']['emailConfirmation']['required'] && !$mailerExists) {
            throw new \RuntimeException('Invalid configuration. Cannot require email confirmation because user mailer is not available. ' . $mailerError);
        }
        if ($app['user.options']['mailer']['enabled'] && !$app['user.options']['mailer']['fromEmail']['address']) {
            throw new \RuntimeException('Invalid configuration. Mailer fromEmail address is required when mailer is enabled.');
        }
        if (!$mailerExists) {
            $app['user.controller']->setPasswordResetEnabled(false);
        }

        if (isset($app['user.passwordStrengthValidator'])) {
            $app['user.manager']->setPasswordStrengthValidator($app['user.passwordStrengthValidator']);
        }
    }

    protected function setDefaultOptions(Application $app)
    {
        $app['user.options.default'] = [

            // Specify custom view templates here.
            'templates' => [
                'layout' => '@user/layout.html.twig',
                'fragment-layout' => '@user/fragment-layout.html.twig',
                'register' => '@user/register.html.twig',
                'register-confirmation-sent' => '@user/register-confirmation-sent.html.twig',
                'login' => '@user/login.html.twig',
                'login-confirmation-needed' => '@user/login-confirmation-needed.html.twig',
                'forgot-password' => '@user/forgot-password.html.twig',
                'reset-password' => '@user/reset-password.html.twig',
                'view' => '@user/view.html.twig',
                'edit' => '@user/edit.html.twig',
                'change-password' => '@user/change-password.html.twig',
                'list' => '@user/list.html.twig',
            ],

            // Specify the forms
            'forms' => [
                'register' => RegisterType::class,
                'edit' => EditType::class,
                'change_password' => ChangePasswordType::class,
                'forgot_password' => ForgotPasswordType::class,
                'reset_password' => ResetPasswordType::class
            ],

            // Configure the user mailer for sending password reset and email confirmation messages.
            'mailer' => [
                'enabled' => true, // When false, email notifications are not sent (they're silently discarded).
                'fromEmail' => [
                    'address' => 'do-not-reply@' . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : gethostname()),
                    'name' => null,
                ],
            ],

            'emailConfirmation' => [
                'required' => false, // Whether to require email confirmation before enabling new accounts.
                'template' => '@user/email/confirm-email.txt.twig',
            ],

            'passwordReset' => [
                'template' => '@user/email/reset-password.txt.twig',
                'tokenTTL' => 86400, // How many seconds the reset token is valid for. Default: 1 day.
            ],

            // Set this to use a custom User class.
            'userClass' => 'rootLogin\UserProvider\Entity\User',

            // Whether to require that users have a username (default: false).
            // By default, users sign in with their email address instead.
            'isUsernameRequired' => false,

            // List of available roles.
            'roles' => [
                'ROLE_ADMIN' => 'This user has administrator privileges.'
            ],

            // A list of custom fields to support in the edit controller. (dbal mode only)
            'editCustomFields' => [],

            // Override database connection, if necessary. (dbal only)
            'userConnection' => 'default',

            // Override table names, if necessary. (dbal only)
            'userTableName' => 'users',
            'userCustomFieldsTableName' => 'user_custom_fields',

            // Override column names if necessary. (dbal mode only)
            'userColumns' => [
                'id' => 'id',
                'email' => 'email',
                'password' => 'password',
                'salt' => 'salt',
                'roles' => 'roles',
                'name' => 'name',
                'time_created' => 'time_created',
                'username' => 'username',
                'isEnabled' => 'isEnabled',
                'confirmationToken' => 'confirmationToken',
                'timePasswordResetRequested' => 'timePasswordResetRequested',
                //Custom Fields
                'user_id' => 'user_id',
                'attribute' => 'attribute',
                'value' => 'value',
            ]
        ];
    }

    protected function initializeOptions(Container $app)
    {
        $app['user.options.init'] = $app->protect(function () use ($app) {
            $options = $app['user.options.default'];
            if (isset($app['user.options'])) {
                // Merge default and configured options
                $options = array_replace_recursive($options, $app['user.options']);

                // Migrate deprecated options for backward compatibility
                if (isset($app['user.options']['layoutTemplate']) && !isset($app['user.options']['templates']['layout'])) {
                    $options['templates']['layout'] = $app['user.options']['layoutTemplate'];
                }
                if (isset($app['user.options']['loginTemplate']) && !isset($app['user.options']['templates']['login'])) {
                    $options['templates']['login'] = $app['user.options']['loginTemplate'];
                }
                if (isset($app['user.options']['registerTemplate']) && !isset($app['user.options']['templates']['register'])) {
                    $options['templates']['register'] = $app['user.options']['registerTemplate'];
                }
                if (isset($app['user.options']['viewTemplate']) && !isset($app['user.options']['templates']['view'])) {
                    $options['templates']['view'] = $app['user.options']['viewTemplate'];
                }
                if (isset($app['user.options']['editTemplate']) && !isset($app['user.options']['templates']['edit'])) {
                    $options['templates']['edit'] = $app['user.options']['editTemplate'];
                }
                if (isset($app['user.options']['listTemplate']) && !isset($app['user.options']['templates']['list'])) {
                    $options['templates']['list'] = $app['user.options']['listTemplate'];
                }
            }
            $app['user.options'] = $options;
        });
    }

    protected function initializeUserManager(Container $app)
    {
        $app['user.provider'] = function ($app) {
            $app['user.options.init']();
            return new UserProvider($app);
        };

        $this->addDoctrineOrmMappings($app);
    }

    protected function initializeUserController(Container $app)
    {
        $app['user.controller'] = function ($app) {
            $app['user.options.init']();

            $controller = new UserController($app['user.manager'], $app['form.factory'], $app['translator']);
            $controller->setUsernameRequired($app['user.options']['isUsernameRequired']);
            $controller->setEmailConfirmationRequired($app['user.options']['emailConfirmation']['required']);
            $controller->setTemplates($app['user.options']['templates']);
            $controller->setEditCustomFields($app['user.options']['editCustomFields']);
            $controller->setForms($app['user.options']['forms']);

            return $controller;
        };
    }

    protected function initializeMailer(Container $app)
    {
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
    }

    protected function addDoctrineOrmMappings(Container $app)
    {
        if (!isset($app['orm.ems.options'])) {
            $app['orm.ems.options'] = function () use ($app) {
                $options = [
                    'default' => $app['orm.em.default_options']
                ];
                return $options;
            };
        }

        $app['orm.ems.options'] = $app->extend('orm.ems.options', function (array $options) {
            $options['default']['mappings'][] = [
                'type' => 'yml',
                'namespace' => 'rootLogin\UserProvider\Entity',
                'path' => $this->getEntityMappingsPath()
            ];
            return $options;
        });
    }

    protected function addValidators(Container $app)
    {
        $app['validator.emailisunique'] = function ($app) {
            $validator =  new EMailIsUniqueValidator();
            $validator->setUserManager($app['user.manager']);

            return $validator;
        };
        $app['validator.emailexists'] = function ($app) {
            $validator =  new EMailExistsValidator();
            $validator->setUserManager($app['user.manager']);

            return $validator;
        };

        if (is_array($app['validator.validator_service_ids'])) {
            $app['validator.validator_service_ids'] = array_merge(
                $app['validator.validator_service_ids'],
                [
                    'validator.emailisunique' => 'validator.emailisunique',
                    'validator.emailexists' => 'validator.emailexists'
                ]
            );
        } else {
            $app['validator.validator_service_ids'] = [
                'validator.emailisunique' => 'validator.emailisunique',
                'validator.emailexists' => 'validator.emailexists'
            ];
        }
    }

    protected function addFormTypes(Container $app)
    {
        if (!isset($app['form.types'])) {
            return;
        }
        $app['form.types'] = $app->extend('form.types', function ($types) use ($app) {
            $types[] = new RegisterType();
            $types[] = new EditType($app['security.authorization_checker']);
            $types[] = new UserRolesType($app['user.options']);
            $types[] = new ChangePasswordType();
            $types[] = new ForgotPasswordType();
            $types[] = new ResetPasswordType();

            return $types;
        });
    }
}
