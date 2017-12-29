<?php

namespace Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SmsRuProviderFactory extends AbstractProviderFactory
{
    public function create(ContainerBuilder $containerBuilder, string $providerName, array $config): void
    {
        $providerDefinition = new ChildDefinition('yamilovs_sms.prototype.provider.sms_ru');
        $providerDefinition
            ->addArgument($config['api_id'])
            ->addArgument($config['from'])
            ->addArgument($config['test'])
        ;

        $this->setProviderDefinition($containerBuilder, $providerName, $providerDefinition);
    }

    public function getName(): string
    {
        return 'sms_ru';
    }

    public function addConfiguration(ArrayNodeDefinition $nodeDefinition): void
    {
        $nodeDefinition
            ->children()
                ->scalarNode('api_id')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('from')->defaultNull()->end()
                ->booleanNode('test')->defaultFalse()->end()
            ->end()
        ;
    }
}