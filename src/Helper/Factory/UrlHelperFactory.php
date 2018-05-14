<?php
/**
 * ZfcCurrent Plugin Factory
 *
 * @category Popov
 * @package Popov_ZfcCore
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 23.05.2016 15:44
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