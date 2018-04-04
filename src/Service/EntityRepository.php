<?php
namespace Popov\ZfcCore\Service;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository as EntityRepositoryOrm;
use Doctrine\ORM\QueryBuilder;

class EntityRepository extends EntityRepositoryOrm {

	// New
	protected $_alias = 'e';
	protected $_dql = '';
	protected $_parameters = [];

    public function getAlias()
    {
        return $this->_alias;
    }

	/**
	 * @see http://stackoverflow.com/a/14103376/1335142
	 * @param \Closure $closure
	 * @return mixed
	 */
	public function findByQuery(\Closure $closure)
    {
        /** @var QueryBuilder $queryBuilder */
		$queryBuilder = $this->createQueryBuilder($this->_alias);
		$currentQuery = $closure($queryBuilder);

		// \Zend\Debug\Debug::dump($currentQuery->getQuery());
		//return $currentQuery->getQuery()->getResult();
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
		$queryBuilder = $this->createQueryBuilder($this->_alias);
		$currentQuery = call_user_func($query, $queryBuilder);

		// \Zend\Debug\Debug::dump($currentQuery->getQuery());
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