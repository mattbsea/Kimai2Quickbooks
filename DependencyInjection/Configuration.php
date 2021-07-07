<?php

/*
 * This file is part of the DemoBundle for Kimai 2.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\KimaiQuickbooksBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

require_once(__DIR__ . '/../vendor/autoload.php');
use QuickBooksOnline\API\DataService\DataService;


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

        $dataService = DataService::Configure(array(
            'auth_mode' => 'oauth2',
            'ClientID' => 'client_id',
            'ClientSecret' =>  'client_secret',
            'RedirectURI' => 'oauth_redirect_uri',
            'scope' => 'oauth_scope',
            'baseUrl' => "development"
        ));

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('setting_client_id')
                    ->defaultValue('Client ID')
                ->end()
                ->scalarNode('setting_client_secret')
                    ->defaultValue('Client Secret')
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
