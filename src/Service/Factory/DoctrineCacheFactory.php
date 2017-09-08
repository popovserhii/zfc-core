<?php
/**
 * Enter description here...
 *
 * @category Popov
 * @package Popov_ZfcCore
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 14.10.2016 16:51
 */
namespace Popov\ZfcCore\Service\Factory;

use Interop\Container\ContainerInterface;
use Doctrine\Common\Cache\MemcacheCache;

class DoctrineCacheFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $cache = new MemcacheCache();
        $memcache = new \Memcache();
        $memcache->connect('localhost', 11211);
        $cache->setMemcache($memcache);

        return $cache;
    }
}