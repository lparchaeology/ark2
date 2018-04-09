<?php

/**
 * ARK ORM Service Provider.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
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
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Framework\Provider;

/*
 * Simplified/Merged/Extended version of Silex/DoctrineServiceProvider and
 * dflydev/doctrine-orm-service-provider.
 *
 * (c) Dragonfly Development Inc.
 */

use ARK\Database\Connection;
use ARK\Database\Console\Command\DatabaseDropTablesCommand;
use ARK\Database\Console\Command\DatabaseImportCommand;
use ARK\Database\Console\Command\DatabaseTruncateCommand;
use ARK\Database\Database;
use ARK\ORM\Console\Command\GenerateItemEntityCommand;
use ARK\ORM\Driver\StaticPHPDriver;
use ARK\ORM\EntityManager;
use Doctrine\Common\EventManager;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\DBAL\Configuration as DbalConfiguration;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager as DoctrineEntityManager;
use Doctrine\ORM\Mapping\Driver\Driver;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Doctrine\ORM\Mapping\Driver\YamlDriver;
use Gedmo\DoctrineExtensions;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Bridge\Doctrine\Logger\DbalLogger;

class DoctrineServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container) : void
    {
        // Doctrine DBAL Config

        $container['dbs.options.initializer'] = $container->protect(function () use ($container) : void {
            static $initialized = false;
            if ($initialized) {
                return;
            }
            $initialized = true;

            $types = $container['dbs.types.default'];

            // TODO Better error checking for missing files and invalid JSON.
            $container['dbs.settings'] = json_decode(file_get_contents($container['dir.config'].'/database.json'), true);

            $options['config'] = $this->mergeConfig($container['dbs.settings'], 'config');
            $options['data'] = $this->mergeConfig($container['dbs.settings'], 'data');
            $options['user'] = $this->mergeConfig($container['dbs.settings'], 'user');

            if (isset($container['dbs.settings']['connections']['spatial'])) {
                $options['spatial'] = $this->mergeConfig($container['dbs.settings'], 'spatial');
                $types = array_merge($types, $container['dbs.types.spatial']);
            }

            $container['dbs.options'] = $options;
            $container['dbs.default'] = 'data';

            // Load the custom Types
            if (isset($container['dbs.settings']['types'])) {
                $types = array_merge($types, $container['dbs.settings']['types']);
            }
            $container['dbs.types'] = $types;
            foreach ($types as $name => $class) {
                Database::setType($name, $class);
            }
        });

        $container['dbs.config'] = function ($container) {
            $container['dbs.options.initializer']();

            $configs = new Container();
            $logger = $container['logger'] ?? null;
            $stopwatch = $container['stopwatch'] ?? null;
            foreach ($container['dbs.options'] as $name => $options) {
                $configs[$name] = new DbalConfiguration();
                if ($logger) {
                    $sqlLogger = $container['debug'] ? new DebugStack($logger, $stopwatch) : new DbalLogger($logger, $stopwatch);
                    $configs[$name]->setSQLLogger($sqlLogger);
                }
            }

            return $configs;
        };

        $container['dbs.event_manager'] = function ($container) {
            $container['dbs.options.initializer']();

            $managers = new Container();
            foreach ($container['dbs.options'] as $name => $options) {
                $managers[$name] = new EventManager();
            }

            return $managers;
        };

        $container['dbs'] = function ($container) {
            $container['dbs.options.initializer']();

            $dbs = new Container();
            foreach ($container['dbs.options'] as $name => $options) {
                $config = $container['dbs.config'][$name];
                $manager = $container['dbs.event_manager'][$name];
                $dbs[$name] = function ($dbs) use ($options, $config, $manager) {
                    return DriverManager::getConnection($options, $config, $manager);
                };
            }

            return $dbs;
        };

        $container['db.config'] = function ($container) {
            $dbs = $container['dbs.config'];
            return $dbs[$container['dbs.default']];
        };

        $container['db.event_manager'] = function ($container) {
            $dbs = $container['dbs.event_manager'];
            return $dbs[$container['dbs.default']];
        };

        $container['db'] = function ($container) {
            $dbs = $container['dbs'];
            return $dbs[$container['dbs.default']];
        };

        $container->addCommands([
            DatabaseDropTablesCommand::class,
            DatabaseImportCommand::class,
            DatabaseTruncateCommand::class,
            GenerateItemEntityCommand::class,
            //ExecuteCommand::class,
            //MigrateCommand::class,
            //StatusCommand::class,
            //VersionCommand::class,
        ]);
        //$container->addHelper();
        //$this->getHelperSet()->set(new ConnectionHelper($this->app['db']), 'db');

        $container['database'] = function ($container) {
            return new Database($container);
        };

        // Doctrine ORM Config

        /*
         * Doctrine ORM Pimple Service Provider.
         *
         * @author Beau Simensen <beau@dflydev.com>
         */

        $container['orm.proxies_dir'] = $container['dir.cache'].'/doctrine/proxies';

        $container['orm.default_cache'] = ['driver' => 'array'];

        $container['orm.custom.functions.string'] = [];
        $container['orm.custom.functions.numeric'] = [];
        $container['orm.custom.functions.datetime'] = [];
        $container['orm.custom.hydration_modes'] = [];

        $container['orm.em.default_options'] = [
            'connection' => 'default',
            'mappings' => [],
            'types' => [],
            'extensions' => [],
            'listeners' => [],
            'alias' => null,
            'proxies_dir' => $container['orm.proxies_dir'],
            'proxies_namespace' => 'DoctrineProxy',
            'auto_generate_proxies' => true,
            'query_cache' => $container['orm.default_cache'],
            'metadata_cache' => $container['orm.default_cache'],
            'result_cache' => $container['orm.default_cache'],
            'hydration_cache' => $container['orm.default_cache'],
            'class_metadata_factory_name' => 'ARK\ORM\ClassMetadataFactory',
            'entity_listener_resolver' => 'Doctrine\ORM\Mapping\DefaultEntityListenerResolver',
            'naming_strategy' => 'Doctrine\ORM\Mapping\DefaultNamingStrategy',
            'quote_strategy' => 'Doctrine\ORM\Mapping\DefaultQuoteStrategy',
            'default_repository_class' => 'Doctrine\ORM\EntityRepository',
            'repository_factory' => 'Doctrine\ORM\Repository\DefaultRepositoryFactory',
        ];

        $gedmoDir = $container['dir.install'].'/vendor/gedmo/doctrine-extensions/lib/Gedmo';
        $container['orm.extensions'] = [
            'tree' => [
                'mapping' => [
                    'type' => 'php',
                    'namespace' => 'Gedmo\Tree\Entity',
                    'path' => $gedmoDir.'/Tree/Entity',
                ],
                'listener' => 'ARK\ORM\Extension\TreeListener',
            ],
            'timestampable' => [
                'mapping' => [
                    'type' => 'php',
                    'namespace' => 'Gedmo\Timestampable\Entity',
                    'path' => $gedmoDir.'/Timestampable/Entity',
                ],
                'listener' => 'ARK\ORM\Extension\TimestampableListener',
            ],
        ];

        $srcDir = $container['dir.install'].'/src/ARK/server/php';
        $container['orm.em.default_options.mappings'] = new Container();

        $this->setMappings($container, 'config', [
            [
                'type' => 'php',
                'namespace' => 'ARK\Map',
                'path' => $srcDir.'/Map',
            ],
            [
                'type' => 'php',
                'namespace' => 'ARK\Model',
                'path' => [
                    $srcDir.'/Model/Attribute.php',
                    $srcDir.'/Model/Model.php',
                    $srcDir.'/Model/ModelSchema.php',
                ],
            ],
            [
                'type' => 'php',
                'namespace' => 'ARK\Model\Dataclass',
                'path' => $srcDir.'/Model/Dataclass',
            ],
            [
                'type' => 'php',
                'namespace' => 'ARK\Model\Schema',
                'path' => $srcDir.'/Model/Schema',
            ],
            [
                'type' => 'php',
                'namespace' => 'ARK\Routing',
                'path' => $srcDir.'/Routing',
            ],
            [
                'type' => 'php',
                'namespace' => 'ARK\Security',
                'path' => [
                    $srcDir.'/Security/Permission.php',
                    $srcDir.'/Security/Role.php',
                ],
            ],
            [
                'type' => 'php',
                'namespace' => 'ARK\Translation',
                'path' => $srcDir.'/Translation',
            ],
            [
                'type' => 'php',
                'namespace' => 'ARK\View',
                'path' => $srcDir.'/View',
            ],
            [
                'type' => 'php',
                'namespace' => 'ARK\Vocabulary',
                'path' => $srcDir.'/Vocabulary',
            ],
            [
                'type' => 'php',
                'namespace' => 'ARK\Workflow',
                'path' => $srcDir.'/Workflow',
            ],
        ]);

        $this->setMappings($container, 'data', [
            [
                'type' => 'php',
                'namespace' => 'ARK\Entity',
                'path' => $srcDir.'/Entity',
            ],
            [
                'type' => 'php',
                'namespace' => 'ARK\File',
                'path' => $srcDir.'/File',
            ],
            [
                'type' => 'php',
                'namespace' => 'ARK\Message',
                'path' => $srcDir.'/Message',
            ],
            [
                'type' => 'php',
                'namespace' => 'ARK\Model\Fragment',
                'path' => $srcDir.'/Model/Fragment',
            ],
            [
                'type' => 'php',
                'namespace' => 'ARK\Security',
                'path' => [
                    $srcDir.'/Security/Actor.php',
                    $srcDir.'/Security/ActorRole.php',
                    $srcDir.'/Security/ActorUser.php',
                    $srcDir.'/Security/Person.php',
                    $srcDir.'/Security/System.php',
                ],
            ],
        ]);

        $this->setMappings($container, 'spatial', [
            [
                'type' => 'php',
                'namespace' => 'ARK\Spatial\Entity',
                'path' => $srcDir.'/Spatial/Entity',
            ],
        ]);

        $this->setMappings($container, 'user', [
            [
                'type' => 'php',
                'namespace' => 'ARK\Security',
                'path' => [
                    $srcDir.'/Security/Account.php',
                    $srcDir.'/Security/User.php',
                ],
            ],
        ]);

        $container['orm.ems.options.initializer'] = $container->protect(function () use ($container) : void {
            static $initialized = false;

            if ($initialized) {
                return;
            }

            $initialized = true;

            $options['config'] = array_replace(
                $container['orm.em.default_options'],
                [
                    'connection' => 'config',
                    'extensions' => ['tree'],
                    'mappings' => $container['orm.em.default_options.mappings']['config'],
                ]
            );
            $options['data'] = array_replace(
                $container['orm.em.default_options'],
                [
                    'connection' => 'data',
                    'extensions' => ['tree'],
                    'mappings' => $container['orm.em.default_options.mappings']['data'],
                ]
            );
            $options['user'] = array_replace(
                $container['orm.em.default_options'],
                [
                    'connection' => 'user',
                    'mappings' => $container['orm.em.default_options.mappings']['user'],
                ]
            );
            $options['spatial'] = array_replace(
                $container['orm.em.default_options'],
                [
                    'connection' => 'spatial',
                    'mappings' => $container['orm.em.default_options.mappings']['spatial'],
                ]
            );

            foreach ($options as $connection => &$config) {
                foreach ($config['extensions'] as $extension) {
                    $config['mappings'][] = $container['orm.extensions'][$extension]['mapping'];
                    $config['listeners'][] = $container['orm.extensions'][$extension]['listener'];
                }
            }

            $container['orm.ems.options'] = $options;
            $container['orm.ems.default'] = 'data';
        });

        $container['orm.mapping_driver_chain.locator'] = $container->protect(function ($name = null) use ($container) {
            $container['orm.ems.options.initializer']();

            if ($name === null) {
                $name = $container['orm.ems.default'];
            }

            $cacheInstanceKey = 'orm.mapping_driver_chain.instances.'.$name;
            if (isset($container[$cacheInstanceKey])) {
                return $container[$cacheInstanceKey];
            }

            return $container[$cacheInstanceKey] = new MappingDriverChain();
        });

        $container['orm.ems.config'] = function ($container) {
            $container['orm.ems.options.initializer']();

            $configs = new Container();
            foreach ($container['orm.ems.options'] as $name => $options) {
                $config = new Configuration();

                if (!$container['debug']) {
                    //$config->setMetadataCacheImpl($container['orm.default_cache']);
                    //$config->setQueryCacheImpl($container['orm.default_cache']);
                    //$config->setResultCacheImpl($container['orm.default_cache']);
                    //$config->setHydrationCacheImpl($container['orm.default_cache']);
                }

                $config->setProxyDir($options['proxies_dir']);
                $config->setProxyNamespace($options['proxies_namespace']);
                $config->setAutoGenerateProxyClasses($options['auto_generate_proxies']);

                $config->setCustomStringFunctions($container['orm.custom.functions.string']);
                $config->setCustomNumericFunctions($container['orm.custom.functions.numeric']);
                $config->setCustomDatetimeFunctions($container['orm.custom.functions.datetime']);
                $config->setCustomHydrationModes($container['orm.custom.hydration_modes']);

                $config->setClassMetadataFactoryName($options['class_metadata_factory_name']);
                $config->setDefaultRepositoryClassName($options['default_repository_class']);

                $config->setEntityListenerResolver(new $options['entity_listener_resolver']());
                $config->setRepositoryFactory(new $options['repository_factory']());

                $config->setNamingStrategy(new $options['naming_strategy']());
                $config->setQuoteStrategy(new $options['quote_strategy']());

                $chain = $container['orm.mapping_driver_chain.locator']($name);

                foreach ((array) $options['mappings'] as $entity) {
                    if (!is_array($entity)) {
                        throw new \InvalidArgumentException(
                            "The 'orm.em.options' option 'mappings' should be an array of arrays."
                        );
                    }

                    if (isset($entity['alias'])) {
                        $config->addEntityNamespace($entity['alias'], $entity['namespace']);
                    }

                    switch ($entity['type']) {
                        case 'php':
                            $driver = new StaticPHPDriver($entity['path']);
                            break;
                        case 'annotation':
                            $useSimpleAnnotationReader =
                                $entity['use_simple_annotation_reader']
                                ?? true;
                            $driver = $config->newDefaultAnnotationDriver((array) $entity['path'], $useSimpleAnnotationReader);
                            break;
                        case 'yml':
                            $driver = new YamlDriver($entity['path']);
                            break;
                        case 'simple_yml':
                            $driver = new SimplifiedYamlDriver([$entity['path'] => $entity['namespace']]);
                            break;
                        case 'xml':
                            $driver = new XmlDriver($entity['path']);
                            break;
                        case 'simple_xml':
                            $driver = new SimplifiedXmlDriver([$entity['path'] => $entity['namespace']]);
                            break;
                        default:
                            throw new \InvalidArgumentException(sprintf('"%s" is not a recognized driver', $entity['type']));
                            break;
                    }
                    $chain->addDriver($driver, $entity['namespace']);
                }
                //DoctrineExtensions::registerAnnotations();
                $config->setMetadataDriverImpl($chain);

                $configs[$name] = $config;
            }

            return $configs;
        };

        $container['orm.ems'] = function ($container) {
            $container['orm.ems.options.initializer']();

            $ems = new Container();
            foreach ($container['orm.ems.options'] as $name => $options) {
                if ($container['orm.ems.default'] === $name) {
                    // we use shortcuts here in case the default has been overridden
                    $config = $container['orm.em.config'];
                } else {
                    $config = $container['orm.ems.config'][$name];
                }

                $ems[$name] = function ($ems) use ($container, $options, $config, $name) {
                    $em = DoctrineEntityManager::create(
                        $container['dbs'][$options['connection']],
                        $config,
                        $container['dbs.event_manager'][$options['connection']]
                    );
                    $eventManager = $em->getConnection()->getEventManager();
                    foreach ($options['listeners'] as $listener) {
                        $eventManager->addEventSubscriber(new $listener());
                    }
                    return new EntityManager($em, $name);
                };
            }

            return $ems;
        };

        $container['orm.em.config'] = function ($container) {
            $ems = $container['orm.ems.config'];
            return $ems[$container['orm.ems.default']];
        };

        $container['orm.em'] = function ($container) {
            $ems = $container['orm.ems'];
            return $ems[$container['orm.ems.default']];
        };
    }

    private function mergeConfig(array $settings, $conn)
    {
        $connection = $settings['connections'][$conn];
        $connection['wrapperClass'] = Connection::class;
        $server = $settings['servers'][$connection['server']];
        return array_merge($server, $connection);
    }

    private function setMappings(Container $container, string $connection, iterable $mappings) : void
    {
        $custom = $container['ark']['orm']['connection'][$connection]['mappings'] ?? [];
        foreach ($custom as &$mapping) {
            $mapping['path'] = $container['dir.install'].'/'.$mapping['path'];
        }
        $container['orm.em.default_options.mappings'][$connection] = array_merge($mappings, $custom);
    }
}
