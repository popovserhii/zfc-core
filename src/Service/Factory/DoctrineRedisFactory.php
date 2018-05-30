<?php
/**
 * Enter description here...
 *
 * @category Popov
 * @package Popov_ZfcCore
 * @author Popov Sergiy <popow.serhii@gmail.com>
 * @datetime: 14.10.2016 16:51
 */
namespace Popov\ZfcCore\Service\Factory;

use Psr\Container\ContainerInterface;

class DoctrineRedisFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6379);

        return $redis;
    }
}