<?php

/*
 * This file is part of the KimaiQuickbooksBundle for Kimai 2.
 * All rights reserved by Matt Barclay (matt@cascadia-aero.com).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\KimaiQuickbooksBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('kimaiquickbooks');
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('setting_client_id')
                    ->defaultValue('Client ID')
                ->end()
                ->scalarNode('setting_client_secret')
                    ->defaultValue('Client Secret')
                ->end()
                ->scalarNode('setting_oauth_redirect_uri')
                    ->defaultValue('OAuth Redirect URI')
                ->end()
                ->scalarNode('setting_backend')
                    ->defaultValue('development')
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
