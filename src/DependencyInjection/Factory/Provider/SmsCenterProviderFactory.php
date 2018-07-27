<?php

namespace Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;

class SmsCenterProviderFactory extends AbstractProviderFactory
{
    public function getName(): string
    {
        return 'sms_center';
    }

    public function getDefinition(array $config): ChildDefinition
    {
        return (new ChildDefinition('yamilovs_sms.prototype.provider.sms_center'))
            ->addMethodCall('setLogin', [$config['login']])
            ->addMethodCall('setPassword', [$config['password']])
            ->addMethodCall('setSender', [$config['sender']])
            ->addMethodCall('setFlash', [$config['flash']])
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