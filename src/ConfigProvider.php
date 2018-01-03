<?php
/**
 * ZfcCore Popov module
 *
 * @category Popov
 * @package Popov_Base
 * @author Popov Sergiy <popow.serhii@gmail.com>
 * @datetime: 25.07.14 15:04
 */
namespace Popov\ZfcCore;

class ConfigProvider
{
    public function __invoke()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}