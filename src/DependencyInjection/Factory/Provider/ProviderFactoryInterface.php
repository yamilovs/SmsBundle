<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

interface ProviderFactoryInterface
{
    public function getName(): string;

    public function getDefinition(array $config): ChildDefinition;

    public function setProviderDefinition(ContainerBuilder $containerBuilder, string $providerName, ChildDefinition $providerDefinition): void;

    public function buildConfiguration(ArrayNodeDefinition $arrayNodeDefinition): void;
}