<?php

/*
 * This file is part of the TempoSimple project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TempoSimple\Application\WebBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * Loads the bundle's services into the application's DIC.
 */
class TempoSimpleWebExtension extends Extension
{
    /** {@inheritDoc} */
    public function load(array $configs, ContainerBuilder $container)
    {
        $fileLocator = new FileLocator(__DIR__.'/../Resources/config');
        $loader = new XmlFileLoader($container, $fileLocator);

        $loader->load('services.xml');
    }
}
