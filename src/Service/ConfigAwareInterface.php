<?php
/**
 * @category Popov
 * @package Popov_ZfcCore
 * @author Popov Sergiy <popow.serhii@gmail.com>
 * @datetime: 06.04.2016 15:27
 */
namespace Popov\ZfcCore\Service;

interface ConfigAwareInterface
{
    /**
     * @param array $config
     * @return self
     */
    public function setConfig($config);

    /**
     * @return array
     */
    public function getConfig();
}
