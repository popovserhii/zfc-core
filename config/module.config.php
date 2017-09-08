<?php
namespace Popov\ZfcCore;

return [
	'service_manager' => [
		//'aliases' => [],
		//'factories' => [],
		'initializers' => [
			'ConfigAwareInterface' => Service\Factory\ConfigInitializer::class,
            'DomainServiceInitializer' => Service\Factory\DomainServiceInitializer::class,
            'ObjectManagerAwareInterface' => Service\Factory\ObjectManagerInitializer::class,
		],
        /*'factories' => array(
            'doctrine.cache.memcache' => function ($sm) {
                $cache = new \Doctrine\Common\Cache\MemcacheCache();
                $memcache = new \Memcache();
                $memcache->connect('localhost', 11211);
                $cache->setMemcache($memcache);
                return $cache;
            },
        ),*/
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

	'view_manager' => [
		'template_path_stack' => [
			__DIR__ . '/../view',
		],
	],
];