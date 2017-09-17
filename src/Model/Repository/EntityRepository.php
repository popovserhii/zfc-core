<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2017 Serhii Popov
 * This source file is subject to The MIT License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/MIT
 *
 * @category Popov
 * @package Popov_<package>
 * @author Serhii Popov <popow.sergiy@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License (MIT)
 */
namespace Popov\ZfcCore\Model\Repository;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository as OrmEntityRepository;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;

abstract class EntityRepository extends OrmEntityRepository
{
    // New
    protected $alias = 'e';


    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string $field
     * @return string
     */
    public function getFieldAlias($field) {
        return (strpos($field, '.')) ? $field : $this->alias . '.' . $field;
    }

    /**
     * @see http://stackoverflow.com/a/14103376/1335142
     * @param \Closure $closure
     * @return mixed
     */
    public function findByQuery(\Closure $closure)
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $this->createQueryBuilder($this->alias);
        $currentQuery = $closure($queryBuilder);

        return $currentQuery;
    }

    /**
     * @see http://stackoverflow.com/a/16105183/1335142
     * @param Criteria $query
     * @return mixed
     * @throws \Exception
     */
    public function findByCriteria(Criteria $query)
    {
        $queryBuilder = $this->createQueryBuilder($this->alias);
        $currentQuery = call_user_func($query, $queryBuilder);

        return $currentQuery->getQuery()->getResult();
    }

    /**
     * @param string $method Called method
     * @param array $params
     * @return mixed
     */
    public function findWrapper($method, $params)
    {
        $handledParams = [];
        foreach ($params as $param) {
            if (is_object($param) && ($param instanceof \Closure)) {
                $handledParams[] = $param();
            } else {
                $handledParams[] = $param;
            }
        }
        $qb = call_user_func_array([$this, $method], $handledParams);

        return $qb->getQuery()->getResult();
    }
}