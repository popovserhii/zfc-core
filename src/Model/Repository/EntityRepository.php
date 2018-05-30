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

    /**
     * @param NativeQuery $query
     * @param array $data
     * @return NativeQuery
     */
    public function setParametersByArray(NativeQuery $query, array $data) {
        for ($i = 0, $k = count($data); $i < $k; ++$i) {
            $query->setParameter(($i + 1), $data[$i]);
        }

        return $query;
    }

    /**
     * @return int
     */
    public function getNextAutoIncrement() {
        $sql = 'SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?';
        $stmt = $this->_em->getConnection()->prepare($sql);
        $stmt->execute(array(
            $this->getEntityManager()->getConnection()->getDatabase(),
            $this->getClassMetadata()->getTableName(),
        ));
        $result = $stmt->fetchAll();
        if ($result) {
            return (int) $result[0]['AUTO_INCREMENT'];
        }

        return 1;
    }

    /**
     * @param string|array $orderBy , example 'filed' or ['field' => 'ASC', 'field2' => 'DESC']
     * @return EntityRepository
     */
    protected function addOrderBy($orderBy)
    {
        $order = [];
        if (!is_array($orderBy)) {
            if (!empty($orderBy)) {
                $orderBy = (array) $orderBy;
                $orderBy[$orderBy[0]] = 'ASC';
                unset($orderBy[0]);
            } else {
                return $this;
            }

        }
        foreach ($orderBy as $field => $by) {
            $order[] = "{$field} {$by}";
        }
        if ($order) {
            $this->_dql .= ' ORDER BY ' . implode(', ', $order);
        }

        return $this;

    }
}