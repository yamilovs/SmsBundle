<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\Tests\DependencyInjection\Factory\Provider;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider\AbstractProviderFactory;

trait ProviderConfigurationTestTrait
{
    protected function getProviderDefinitions(AbstractProviderFactory $providerFactory): array
    {
        $definition = new ArrayNodeDefinition(null);
        $providerFactory->addConfiguration($definition);

        return $definition->getChildNodeDefinitions();
    }
}