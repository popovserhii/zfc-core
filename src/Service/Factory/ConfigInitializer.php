<?php
/**
 * Config Initializer
 *
 * @category Popov
 * @package Popov_ZfcCore
 * @author Popov Sergiy <popow.serhii@gmail.com>
 * @datetime: 06.04.2016 22:57
 */
namespace Popov\ZfcCore\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Popov\ZfcCore\Service\ConfigAwareInterface;

class ConfigInitializer
{
    public function __invoke(ServiceLocatorInterface $sm, $instance)
    {
        if ($instance instanceof ConfigAwareInterface) {
            $instance->setConfig($sm->get('Config'));
        }
    }
}