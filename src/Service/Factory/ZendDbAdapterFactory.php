<?php
/**
 * Zend Database Adapter Factory
 *
 * @category Popov
 * @package Popov_ZfcCore
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 14.10.2016 16:51
 */
namespace Popov\ZfcCore\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;

class ZendDbAdapterFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbParams = $container->get('Config')['database'];

        return new Adapter([
            'driver' => 'pdo',
            'driver_options' => [
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
                \PDO::MYSQL_ATTR_FOUND_ROWS => true,
            ],
            'dsn' => 'mysql:dbname=' . $dbParams['database'] . ';host=' . $dbParams['hostname'],
            'database' => $dbParams['database'],
            'username' => $dbParams['username'],
            'password' => $dbParams['password'],
            'hostname' => $dbParams['hostname'],
        ]);
    }
}