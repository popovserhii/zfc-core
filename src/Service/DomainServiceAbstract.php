<?php
/**
 * Abstract class for most services classes
 *
 * @category Popov
 * @package Popov_ZfcCore
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 06.04.2016 15:57
 */
namespace Popov\ZfcCore\Service;

use Zend\EventManager\EventManagerAwareTrait;
use DoctrineModule\Persistence\ProvidesObjectManager;

abstract class DomainServiceAbstract implements DomainServiceInterface
{
    use EventManagerAwareTrait;
    use ProvidesObjectManager;

    /**
     * Full qualified object name
     *
     * @var string
     */
    protected $entity;

    public function getRepository()
    {
        return $this->getObjectManager()->getRepository($this->entity);
    }

    public function getObjectModel()
    {
        $entityName = $this->getRepository()->getClassName();

        $entity = new $entityName();
        $this->getObjectManager()->persist($entity);

        return $entity;
    }

    public function getObjectName()
    {
        return $this->entity;
    }

    public function find($id)
    {
        return $this->getObjectManager()->find($this->entity, $id);
    }
}
