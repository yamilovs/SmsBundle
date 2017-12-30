<?php

namespace Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SmsCenterProviderFactory extends AbstractProviderFactory
{
    public function create(ContainerBuilder $containerBuilder, string $providerName, array $config): void
    {
        $providerDefinition = new ChildDefinition('yamilovs_sms.prototype.provider.sms_center');
        $providerDefinition
            ->addArgument($config['login'])
            ->addArgument($config['password'])
            ->addArgument($config['sender'])
            ->addArgument($config['flash'])
        ;

        $this->setProviderDefinition($containerBuilder, $providerName, $providerDefinition);
    }

    public function getName(): string
    {
        return 'sms_center';
    }

    public function addConfiguration(ArrayNodeDefinition $nodeDefinition): void
    {
        $nodeDefinition
            ->children()
                ->scalarNode('login')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('password')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('sender')
                    ->defaultNull()
                ->end()
                ->booleanNode('flash')
                    ->defaultFalse()
                ->end()
            ->end()
        ;
    }
}