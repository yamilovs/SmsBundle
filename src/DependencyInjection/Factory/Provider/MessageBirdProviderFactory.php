<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;

class MessageBirdProviderFactory extends AbstractProviderFactory
{
    public function getName(): string
    {
        return 'message_bird';
    }

    public function getDefinition(array $config): ChildDefinition
    {
        return (new ChildDefinition('yamilovs_sms.prototype.provider.message_bird'))
            ->addMethodCall('setAccessKey', [$config['access_key']])
            ->addMethodCall('setOriginator', [$config['originator']])
            ->addMethodCall('setType', [$config['type']])
        ;
    }

    public function buildConfiguration(ArrayNodeDefinition $nodeDefinition): void
    {
        $nodeDefinition
            ->children()
                ->scalarNode('access_key')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('originator')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('type')
                    ->defaultValue('sms')
                    ->validate()
                    ->ifNotInArray(['sms', 'binary', 'flash'])
                        ->thenInvalid('Invalid type value: "%s"')
                    ->end()
                ->end()
            ->end()
        ;
    }
}