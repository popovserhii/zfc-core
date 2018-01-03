<?php
/**
 * Domain Service Initializer
 *
 * @category Popov
 * @package Popov_ZfcCore
 * @author Popov Sergiy <popow.serhii@gmail.com>
 * @datetime: 06.04.2016 22:57
 */
namespace Popov\ZfcCore\Service\Factory;

use Zend\Stdlib\Exception;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;
use Popov\ZfcCore\Service\DomainServiceAwareInterface;

class DomainServiceInitializer
{
    public function __invoke(ServiceLocatorInterface $sm, $instance)
    {
        if ($instance instanceof DomainServiceAwareInterface) {
            if (ServiceManager::class !== get_class($sm)) {
                $sm = $sm->getServiceLocator();
            }

            $object = null;
            if (method_exists($instance, 'getObject')) {
                $object = $instance->getObject();
            } elseif (method_exists($instance, 'getObjectModel')) {
                $object = $instance->getObjectModel();
            } else {
                throw new Exception\BadMethodCallException(sprintf(
                    'Cannot retrieve Domain Object from instance %s. Methods "getObject" or "getObjectModel" not exist.'
                    . ' If class implements "%s" than it must return related Domain Object.',
                    get_class($instance),
                    DomainServiceAwareInterface::class
                ));
            }

            $serviceName = str_replace('Model', 'Service', get_class($object)) . 'Service';

            $instance->setDomainService($sm->get($serviceName));
        }
    }
}