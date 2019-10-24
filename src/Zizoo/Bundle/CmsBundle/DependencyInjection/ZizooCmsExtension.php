<?php

namespace Zizoo\Bundle\CmsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ZizooCmsExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        
        if(!$container->hasParameter('instagram.api.access_token')) {
            throw new Exception('instagram.api.access_token parameter is not defined in parameters.yml');
        }

        if(!$container->hasParameter('instagram.api.get_recent_media_count')) {
            throw new Exception('instagram.api.get_recent_media_count parameter is not defined in parameters.yml');
        }

        if(!$container->hasParameter('instagram.api.username')) {
            throw new Exception('instagram.api.username parameter is not defined in parameters.yml');
        }
    }
}
