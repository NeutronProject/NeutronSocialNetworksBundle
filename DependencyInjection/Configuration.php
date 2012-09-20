<?php

namespace Neutron\Widget\SocialNetworksBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('neutron_social_networks');

        $this->addGeneralConfigurations($rootNode);
        $this->addWidgetOptionsSection($rootNode);
        $this->addFormSection($rootNode);

        return $treeBuilder;
    }
    
    private function addGeneralConfigurations(ArrayNodeDefinition $node)
    {
        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enable')->defaultFalse()->end()
                ->scalarNode('controller_administration')->defaultValue('neutron_social_networks.controller.administration.default')->end()
                ->scalarNode('controller_front')->defaultValue('neutron_social_networks.controller.front.default')->end()
                ->scalarNode('manager')->defaultValue('neutron_social_networks.manager.default')->end()
                ->scalarNode('translation_domain')->defaultValue('NeutronSocialNetworksBundle')->end()
                ->scalarNode('grid')->defaultValue('social_network_management')->end()
                ->scalarNode('social_network_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('template')->isRequired()->cannotBeEmpty()->end()
            ->end()
        ;
    }
    
    private function addWidgetOptionsSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('widget_options')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->booleanNode('plugin_aware')->defaultFalse()->end()
                            ->booleanNode('panel_aware')->defaultFalse()->end()
                            ->arrayNode('allowed_plugins')
                                ->prototype('scalar')->end()
                                ->defaultValue(array())
                            ->end()
                            ->arrayNode('allowed_panels')
                                ->prototype('scalar')->end()
                                ->defaultValue(array())
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
    
    private function addFormSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('form')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('type')->defaultValue('neutron_social_network')->end()
                            ->scalarNode('handler')->defaultValue('neutron_social_networks.form.handler.social_network.default')->end()
                            ->scalarNode('name')->defaultValue('neutron_social_network')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
