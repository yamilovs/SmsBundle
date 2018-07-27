<?php

namespace Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;

class SmsAeroProviderFactory extends AbstractProviderFactory
{
    public function getName(): string
    {
        return 'sms_aero';
    }

    public function getDefinition(array $config): ChildDefinition
    {
        return (new ChildDefinition('yamilovs_sms.prototype.provider.sms_aero'))
            ->addMethodCall('setUser', [$config['user']])
            ->addMethodCall('setApiKey', [$config['api_key']])
            ->addMethodCall('setSign', [$config['sign']])
            ->addMethodCall('setChannel', [$config['channel']])
        ;
    }

    public function buildConfiguration(ArrayNodeDefinition $nodeDefinition): void
    {
        $nodeDefinition
            ->children()
                ->scalarNode('user')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('api_key')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('sign')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('channel')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->validate()
                    ->ifNotInArray(['INFO', 'DIGITAL', 'INTERNATIONAL', 'DIRECT', 'SERVICE'])
                        ->thenInvalid('Invalid channel value: "%s"')
                    ->end()
                ->end()
            ->end()
        ;
    }
}