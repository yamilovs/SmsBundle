<?php

namespace Yamilovs\Bundle\SmsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider\AbstractProviderFactory;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @var AbstractProviderFactory[]
     */
    private $providerFactoryMap = [];

    public function __construct(array $providerFactoryMap)
    {
        $this->providerFactoryMap = $providerFactoryMap;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('yamilovs_sms');

        $this->addProvidersSection($rootNode);

        return $treeBuilder;
    }

    private function addProvidersSection(ArrayNodeDefinition $nodeDefinition)
    {
        $nd = $nodeDefinition
            ->fixXmlConfig('provider', 'providers')
            ->children()
                ->arrayNode('providers')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->performNoDeepMerging()
        ;

        foreach ($this->providerFactoryMap as $providerName => $providerFactory) {
            $providerFactory->addConfiguration(
                $nd->children()->arrayNode($providerName)
            );
        }
    }
}