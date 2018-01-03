<?php
/**
 * Domain
 *
 * @category Popov
 * @package Popov_ZfcCore
 * @author Popov Sergiy <popow.serhii@gmail.com>
 * @datetime: 06.04.2016 15:27
 */
namespace Popov\ZfcCore\Service;

interface DomainServiceAwareInterface
{
    /**
     * Set Service related with Domain Entity
     *
     * @param $domainService
     * @return self
     */
    public function setDomainService($domainService);

    /**
     * Retrieve Service related with Domain Entity
     *
     * @return DomainServiceAbstract
     */
    public function getDomainService();
}
