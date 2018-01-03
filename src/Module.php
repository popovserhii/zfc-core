<?php
/**
 * ZfcCore Popov module
 *
 * @category Popov
 * @package Popov_Base
 * @author Popov Sergiy <popow.serhii@gmail.com>
 * @datetime: 25.07.14 15:04
 */
namespace Popov\ZfcCore;

use Zend\Mvc\ModuleRouteListener;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function onBootstrap($e)
    {
        //$e->getApplication()->getServiceManager()->get('translator');
        //$eventManager = $e->getApplication()->getEventManager();
        //$moduleRouteListener = new ModuleRouteListener();
        //$moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}