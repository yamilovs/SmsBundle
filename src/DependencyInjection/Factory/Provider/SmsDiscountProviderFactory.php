<?php

namespace Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;

class SmsDiscountProviderFactory extends AbstractProviderFactory
{
    public function getName(): string
    {
        return 'sms_discount';
    }

    public function getDefinition(array $config): ChildDefinition
    {
        return (new ChildDefinition('yamilovs_sms.prototype.provider.sms_discount'))
            ->addArgument($config['login'])
            ->addArgument($config['password'])
            ->addArgument($config['sender'])
            ->addArgument($config['flash'])
        ;
    }

    public function buildConfiguration(ArrayNodeDefinition $nodeDefinition): void
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