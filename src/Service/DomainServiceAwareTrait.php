<?php
/**
 * @category Popov
 * @package Popov_ZfcCore
 * @author Popov Sergiy <popow.serhii@gmail.com>
 * @datetime: 06.04.2016 15:27
 */
namespace Popov\ZfcCore\Service;

trait DomainServiceAwareTrait
{
    /**
     * @var DomainServiceAbstract
     */
    protected $domainService;

    /**
     * Set Service related with Domain Entity
     *
     * @param $domainService
     * @return self
     */
    public function setDomainService($domainService)
    {
        $this->domainService = $domainService;
    }

    /**
     * Retrieve Service related with Domain Entity
     *
     * @return DomainServiceAbstract
     */
    public function getDomainService()
    {
        return $this->domainService;
    }
}
