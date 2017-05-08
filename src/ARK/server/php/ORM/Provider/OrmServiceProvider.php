<?php

/**
 * ARK ORM Service Provider
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

namespace ARK\ORM\Provider;

/*
 * Simplified/Extended version of dflydev/doctrine-orm-service-provider.
 *
 * (c) Dragonfly Development Inc.
 */

use ARK\ORM\Command\GenerateItemEntityMessage;
use ARK\ORM\Command\GenerateItemEntityHandler;
use ARK\ORM\Driver\StaticPHPDriver;
use ARK\ORM\EntityManager;
use ARK\ORM\Item\ItemMappingDriver;
use ARK\ORM\UnitOfWork;
use Doctrine\Common\Cache\CacheProvider;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager as DoctrineEntityManager;
use Doctrine\ORM\Mapping\Driver\Driver;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Doctrine\ORM\Mapping\Driver\YamlDriver;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Gedmo\DoctrineExtensions;

/**
 * Doctrine ORM Pimple Service Provider.
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class OrmServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $commands = [
            GenerateItemEntityMessage::class => GenerateItemEntityHandler::class,
        ];
        $container['bus.command.handlers'] = array_merge($container['bus.command.handlers'], $commands);

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

        $container['orm.ems.options.initializer'] = $container->protect(function () use ($container) {
            static $initialized = false;

            if ($initialized) {
                return;
            }

            $initialized = true;

            $srcDir = $container['dir.install'].'/src/ARK/server/php';
            $options['core'] = array_replace(
                $container['orm.em.default_options'],
                [
                    'connection' => 'core',
                    'extensions' => ['tree'],
                    'mappings' => [
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
                                $srcDir.'/Model/Datatype.php',
                                $srcDir.'/Model/Format.php',
                                $srcDir.'/Model/Module.php',
                                $srcDir.'/Model/Schema.php',
                            ]
                        ],
                        [
                            'type' => 'php',
                            'namespace' => 'ARK\Model\Format',
                            'path' => $srcDir.'/Model/Format',
                        ],
                        [
                            'type' => 'php',
                            'namespace' => 'ARK\Model\Schema',
                            'path' => $srcDir.'/Model/Schema',
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
                    ],
                ]
            );
            $options['data'] = array_replace(
                $container['orm.em.default_options'],
                [
                    'connection' => 'data',
                    'extensions' => ['tree'],
                    'mappings' => [
                        [
                            'type' => 'item',
                            'namespace' => 'ARK\Actor',
                            'path' => $srcDir.'/Actor',
                        ],
                        [
                            'type' => 'item',
                            'namespace' => 'ARK\Message',
                            'path' => $srcDir.'/Message',
                        ],
                        [
                            'type' => 'php',
                            'namespace' => 'ARK\Model',
                            'path' => $srcDir.'/Model/Fragment.php',
                        ],
                        [
                            'type' => 'php',
                            'namespace' => 'ARK\Model\Fragment',
                            'path' => $srcDir.'/Model/Fragment',
                        ],
                        [
                            'type' => 'item',
                            'namespace' => 'ARK\Entity',
                        ],
                        [
                            'type' => 'item',
                            'namespace' => 'ARK\File',
                        ],
                        [
                            'type' => 'php',
                            'namespace' => 'ARK\Security',
                            'path' => $srcDir.'/Security',
                        ],
                        [
                            'type' => 'item',
                            'namespace' => 'ARK\Workflow',
                            'path' => $srcDir.'/Workflow',
                        ],
                        [
                            'type' => 'item',
                            'namespace' => 'DIME\Entity',
                        ],
                    ],
                ]
            );
            $options['user'] = array_replace(
                $container['orm.em.default_options'],
                [
                    'connection' => 'user',
                    [
                        'type' => 'php',
                        'namespace' => 'ARK\Security',
                        'path' => $srcDir.'/Security',
                    ]
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

            return $container[$cacheInstanceKey] = new MappingDriverChain;
        });

        $container['orm.ems.config'] = function ($container) {
            $container['orm.ems.options.initializer']();

            $configs = new Container();
            foreach ($container['orm.ems.options'] as $name => $options) {
                $config = new Configuration;

                if (!$container['debug']) {
                    $config->setMetadataCacheImpl($container['cache.orm.system']);
                    $config->setQueryCacheImpl($container['cache.orm.system']);
                    $config->setResultCacheImpl($container['cache.orm.app']);
                    $config->setHydrationCacheImpl($container['cache.orm.app']);
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

                $config->setEntityListenerResolver(new $options['entity_listener_resolver']);
                $config->setRepositoryFactory(new $options['repository_factory']);

                $config->setNamingStrategy(new $options['naming_strategy']);
                $config->setQuoteStrategy(new $options['quote_strategy']);

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
                        case 'item':
                            $driver = new ItemMappingDriver($entity['namespace']);
                            break;
                        case 'php':
                            $driver = new StaticPHPDriver($entity['path']);
                            break;
                        case 'annotation':
                            $useSimpleAnnotationReader =
                                isset($entity['use_simple_annotation_reader'])
                                ? $entity['use_simple_annotation_reader']
                                : true;
                            $driver = $config->newDefaultAnnotationDriver((array) $entity['path'], $useSimpleAnnotationReader);
                            break;
                        case 'yml':
                            $driver = new YamlDriver($entity['path']);
                            break;
                        case 'simple_yml':
                            $driver = new SimplifiedYamlDriver(array($entity['path'] => $entity['namespace']));
                            break;
                        case 'xml':
                            $driver = new XmlDriver($entity['path']);
                            break;
                        case 'simple_xml':
                            $driver = new SimplifiedXmlDriver(array($entity['path'] => $entity['namespace']));
                            break;
                        default:
                            throw new \InvalidArgumentException(sprintf('"%s" is not a recognized driver', $entity['type']));
                            break;
                    }
                    $chain->addDriver($driver, $entity['namespace']);
                }
                //DoctrineExtensions::registerAnnotations();
                $config->setMetadataDriverImpl($chain);

                foreach ((array) $options['types'] as $typeName => $typeClass) {
                    if (Type::hasType($typeName)) {
                        Type::overrideType($typeName, $typeClass);
                    } else {
                        Type::addType($typeName, $typeClass);
                    }
                }

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

                $ems[$name] = function ($ems) use ($container, $options, $config) {
                    $em = DoctrineEntityManager::create(
                        $container['dbs'][$options['connection']],
                        $config,
                        $container['dbs.event_manager'][$options['connection']]
                    );
                    $eventManager = $em->getConnection()->getEventManager();
                    foreach ($options['listeners'] as $listener) {
                        $eventManager->addEventSubscriber(new $listener);
                    }
                    return new EntityManager($em);
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
}
