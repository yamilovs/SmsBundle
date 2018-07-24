<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

abstract class AbstractProviderFactory
{
    private const SERVICE_PREFIX = 'yamilovs_sms.provider.';
    public const SERVICE_TAG = 'yamilovs_sms.provider';

    abstract public function create(ContainerBuilder $containerBuilder, string $providerName, array $config): void;

    /**
     * The provider name
     *
     * @return string
     */
    abstract public function getName(): string;

    /**
     * @param ArrayNodeDefinition $nodeDefinition
     */
    abstract public function addConfiguration(ArrayNodeDefinition $nodeDefinition): void;

    protected function setProviderDefinition(ContainerBuilder $containerBuilder, string $providerName, ChildDefinition $providerDefinition)
    {
        $providerDefinition->addTag(self::SERVICE_TAG, ['provider' => $providerName]);
        $providerId = self::SERVICE_PREFIX.$providerName;

        $containerBuilder->setDefinition($providerId, $providerDefinition);
    }
}