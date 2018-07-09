<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2018 Serhii Popov
 * This source file is subject to The MIT License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/MIT
 *
 * @category Popov
 * @package Popov_ZfcCore
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace Popov\ZfcCore\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Popov\ZfcCore\Helper\Config;

class ConfigHelper extends AbstractHelper
{
    /**
     * @var Config
     */
    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function get($path, $default = null)
    {
        return $this->config->get($path, $default);
    }

    public function __invoke()
    {
        $args = func_get_args();
        if ($args) {
            $path = $args[0];
            $default = $args[1] ?? null;

            return $this->get($path, $default);
        }

        return $this;
    }
}