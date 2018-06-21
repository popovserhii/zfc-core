<?php
/**
 * Abstract Table Factory
 *
 * @category Popov
 * @package Popov_ZfcCore
 * @author Popov Sergiy <popow.serhii@gmail.com>
 * @datetime: 25.09.16 17:40
 */
namespace Popov\ZfcCore\Model\Table\Factory;

use Interop\Container\ContainerInterface;

class TableFactory
{
    public function __invoke(ContainerInterface $container, $name)
    {
        $dbAdapter = $container->get('Zend\Db\Adapter\Adapter');
        $table = new $name($dbAdapter);

        return $table;
    }
}