<?php

namespace Popov\ZfcCore\Service;

use Zend\Paginator\Adapter\AdapterInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

class DoctrinePaginatorAdapter implements AdapterInterface {

    protected $paginator = null;
    protected $count = null;

    public function __construct(Paginator $paginator) {
        $this->paginator = $paginator;
        $this->count = count($paginator);
    }

    public function getItems($offset, $itemCountPerPage) {
        return $this->paginator->getIterator();
    }

    public function count() {
        return $this->count;
    }
}