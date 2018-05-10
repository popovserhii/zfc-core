<?php
/**
 * Abstract class for most services classes
 *
 * @category Popov
 * @package Popov_ZfcCore
 * @author Popov Sergiy <popow.serhii@gmail.com>
 * @datetime: 06.04.2016 15:57
 */
namespace Popov\ZfcCore\Service;

use Doctrine\ORM\QueryBuilder;
use Zend\EventManager\EventManagerAwareTrait;
use DoctrineModule\Persistence\ProvidesObjectManager;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Zend\Paginator\Paginator as ZendPaginator;

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

    /**
     * @param QueryBuilder $results
     * @param $page
     * @param $limit
     * @return ZendPaginator
     */
    public function getPaginator(QueryBuilder $results, $page, $limit)
    {
        $queryResults = new DoctrinePaginator($results->getQuery());
        $adapter = new DoctrinePaginatorAdapter($queryResults);
        $paginator = new ZendPaginator($adapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($limit);

        return $paginator;
    }


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
