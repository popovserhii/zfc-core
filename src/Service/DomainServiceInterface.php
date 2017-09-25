<?php
/**
 * Domain
 *
 * @category Popov
 * @package Popov_ZfcCore
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 06.04.2016 15:27
 */
namespace Popov\ZfcCore\Service;

use Zend\EventManager\EventManagerAwareInterface;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;

interface DomainServiceInterface extends EventManagerAwareInterface, ObjectManagerAwareInterface
{
    /**
     * Retrieve Repository object related with service
     */
    public function getRepository();

    /**
     * Retrieve Model object related with service
     *
     * @return object Model
     */
    public function getObjectModel();

    /**
     * Get fully qualified object name
     *
     * @return string
     */
    public function getObjectName();

    /**
     * Find related entity by id
     *
     * @param int|string $id
     * @return object Model
     */
    public function find($id);
}
