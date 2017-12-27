<?php

namespace Yamilovs\Bundle\SmsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider\ProviderFactoryInterface;
use Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider\SmsruProviderFactory;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
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
        $nodeDefinition
            ->children()
                ->fixXmlConfig('adapter', 'adapters')
                ->children()
                    ->arrayNode('adapters')
                        ->useAttributeAsKey('name')
                        ->arrayPrototype()
        ;

        /** @var ProviderFactoryInterface $providerFactory */
        foreach ($this->getProviderFactories() as $providerFactory) {
            $providerFactory->addConfiguration(
                $nodeDefinition->children()->arrayNode($providerFactory->getName())
            );
        }
    }

    /**
     * @return ProviderFactoryInterface[]
     */
    private function getProviderFactories(): array
    {
        return [
            new SmsruProviderFactory(),
        ];
    }
}