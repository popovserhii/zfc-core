<?php
/**
 * @category Popov
 * @package Popov_ZfcCore
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 06.04.2016 15:27
 */
namespace Popov\ZfcCore\Service;

trait ConfigAwareTrait
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @param array $config
     * @return self
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }
}
