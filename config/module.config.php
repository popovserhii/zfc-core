<?php
namespace Popov\ZfcCore;

use Psr\Container\ContainerInterface;

return [
    'doctrine' => [
        'cache' => [
            'redis' => [
                'namespace' => __NAMESPACE__ . '_Doctrine',
                'instance'  => __NAMESPACE__ . '\Cache\Redis',
            ],
        ],
    ],

	'dependencies' => [
		'aliases' => [
		    //'Zend\Db\Adapter\AdapterInterface' => 'Zend\Db\Adapter\AdapterInterface',
            //'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\Adapter',
        ],
        'invokables' => [
            //'Zend\Db\Adapter\Adapter' => Service\Factory\ZendDbAdapterFactory::class,
            //'Zend\Db\Adapter\AdapterInterface' => Service\Factory\ZendDbAdapterFactory::class,
        ],
		'factories' => [
            Helper\Config::class => Helper\Factory\ConfigFactory::class,
            Helper\UrlHelper::class => Helper\Factory\UrlHelperFactory::class,
            ContainerInterface::class => Service\Factory\ContainerFactory::class,
            'doctrine.cache.memcache' => Service\Factory\DoctrineMemcacheFactory::class,
            __NAMESPACE__ . '\Cache\Redis' => Service\Factory\DoctrineRedisFactory::class,
            'Zend\Db\Adapter\Adapter' => \Zend\Db\Adapter\AdapterServiceFactory::class,
        ],
		'initializers' => [
			'ConfigAwareInterface' => Service\Factory\ConfigInitializer::class,
            'DomainServiceInitializer' => Service\Factory\DomainServiceInitializer::class,
            'ObjectManagerAwareInterface' => Service\Factory\ObjectManagerInitializer::class,
		],
	],

    'controller_plugins' => [
        'aliases' => [
            'config' => Controller\Plugin\ConfigPlugin::class,
        ],
    ],

    'view_helpers' => [
        'aliases' => [
            'config' => View\Helper\ConfigHelper::class,
        ],
    ],

	'validators' => [
		//'aliases' => [],
		//'factories' => [],
		'initializers' => [
			'ConfigAwareInterface' => Service\Factory\ConfigInitializer::class,
            //'DomainServiceInitializer' => Service\Factory\DomainServiceInitializer::class,
            'ObjectManagerAwareInterface' => Service\Factory\ObjectManagerInitializer::class,
		],
	],
];