<?php
/**
 * Abstract Table Factory
 *
 * @category Popov
 * @package Popov_ZfcCore
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 25.09.16 17:40
 */
namespace Popov\ZfcCore\Model\Table\Factory;

use Interop\Container\ContainerInterface;

class TableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('Zend\Db\Adapter\Adapter');
        $tableRealName = func_get_args()[2];
        $table = new $tableRealName($dbAdapter);

        return $table;
    }
}