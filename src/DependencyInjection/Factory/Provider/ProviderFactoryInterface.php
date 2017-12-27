<?php

namespace Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

interface ProviderFactoryInterface
{
    public function create(ContainerBuilder $containerBuilder, string $providerName, array $config): string;

    /**
     * The provider name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * @param ArrayNodeDefinition $nodeDefinition
     */
    public function addConfiguration(ArrayNodeDefinition $nodeDefinition): void;
}