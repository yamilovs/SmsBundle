<?php

namespace Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SmsDiscountProviderFactory implements ProviderFactoryInterface
{
    public function create(ContainerBuilder $containerBuilder, string $providerName, array $config): string
    {
        $providerDefinition = new ChildDefinition('yamilovs_sms.prototype.provider.sms_discount');
        $providerDefinition
            ->addArgument($config['login'])
            ->addArgument($config['password'])
            ->addArgument($config['sender'])
            ->addArgument($config['flash'])
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
        return 'sms_discount';
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