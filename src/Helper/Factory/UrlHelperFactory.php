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

namespace Popov\ZfcCore\Helper\Factory;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Expressive\Helper\UrlHelper as ExpressiveUrlHelper;
use Popov\ZfcCore\Helper\UrlHelper;

class UrlHelperFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $isExpressive = class_exists(Application::class);

        $urlHelper = $isExpressive
            ? $container->get(ExpressiveUrlHelper::class)
            : $container->get('ViewHelperManager')->get('url');

        return new UrlHelper($urlHelper);
    }
}