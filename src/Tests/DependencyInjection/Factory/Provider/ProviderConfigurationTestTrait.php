<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\Tests\DependencyInjection\Factory\Provider;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider\ProviderFactoryInterface;

trait ProviderConfigurationTestTrait
{
    protected function getProviderDefinitions(ProviderFactoryInterface $providerFactory): array
    {
        $definition = new ArrayNodeDefinition(null);
        $providerFactory->buildConfiguration($definition);

        return $definition->getChildNodeDefinitions();
    }
}