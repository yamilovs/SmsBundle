<?php

namespace Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SmsAeroProviderFactory implements ProviderFactoryInterface
{
    public function create(ContainerBuilder $containerBuilder, string $providerName, array $config): string
    {
        $providerDefinition = new ChildDefinition('yamilovs_sms.prototype.provider.sms_aero');
        $providerDefinition
            ->addArgument($config['user'])
            ->addArgument($config['api_key'])
            ->addArgument($config['sign'])
            ->addArgument($config['channel'])
        ;
        $providerDefinition->addTag(self::SERVICE_TAG, [
            'provider' => $providerName,
        ]);
        $providerId = self::SERVICE_PREFIX.$providerName;

        $containerBuilder->setDefinition($providerId, $providerDefinition);

        return $providerId;
    }

    public function getName(): string
    {
        return 'sms_aero';
    }

    public function addConfiguration(ArrayNodeDefinition $nodeDefinition): void
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