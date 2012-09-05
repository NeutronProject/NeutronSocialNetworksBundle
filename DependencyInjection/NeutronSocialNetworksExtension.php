<?php

namespace Neutron\Widget\SocialNetworksBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class NeutronSocialNetworksExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        
        $container->setAlias('neutron_social_networks.controller.administration', $config['controller_administration']);
        $container->setAlias('neutron_social_networks.controller.front', $config['controller_front']);
        $container->setAlias('neutron_social_networks.manager', $config['manager']);
        $container->setParameter('neutron_social_networks.grid', $config['grid']);
        $container->setParameter('neutron_social_networks.social_network_class', $config['social_network_class']);
        $container->setParameter('neutron_social_networks.template', $config['template']);

        $container->setAlias('neutron_social_networks.form.handler.social_network', $config['form']['handler']);
        $container->setParameter('neutron_social_networks.form.type.social_network', $config['form']['type']);
        $container->setParameter('neutron_social_networks.form.name.social_network', $config['form']['name']);
        $container->setParameter('neutron_social_networks.widget_options', $config['widget_options']);

    }
}
