<?php
/**
 * Doctrine Object Manager Initializer
 *
 * @category Popov
 * @package Popov_ZfcCore
 * @author Popov Sergiy <popow.serhii@gmail.com>
 * @datetime: 06.04.2016 22:57
 */
namespace Popov\ZfcCore\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;

class ObjectManagerInitializer
{
    public function __invoke(ServiceLocatorInterface $sm, $instance)
    {
        if (get_class($sm) !== ServiceManager::class) {
            $sm = $sm->getServiceLocator();
        }

        if ($instance instanceof ObjectManagerAwareInterface) {
            $instance->setObjectManager($sm->get('Doctrine\ORM\EntityManager'));
        }
    }
}