<?php
namespace Popov\ZfcCore\Service;

/**
 * User this trait vary reasonably.
 * In most cases you must inject object dependencies through constructor or inject* methods
 *
 * @package Popov\ZfcCore
 */
trait ServiceManagerAwareTrait
{
    protected $serviceManager = null;

    public function setServiceManager($serviceManager)
    {
        $this->serviceManager = $serviceManager;

        return $this;
    }

    public function getServiceManager()
    {
        return $this->serviceManager;
    }
}
