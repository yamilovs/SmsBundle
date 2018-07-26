<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider;

use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

abstract class AbstractProviderFactory implements ProviderFactoryInterface
{
    public const SERVICE_TAG = 'yamilovs_sms.provider';

    public function setProviderDefinition(ContainerBuilder $containerBuilder, string $providerName, ChildDefinition $providerDefinition): void
    {
        $providerDefinition->addTag(self::SERVICE_TAG, ['provider' => $providerName]);
        $providerId = sprintf('yamilovs_sms.provider.%s', $providerName);

        $containerBuilder->setDefinition($providerId, $providerDefinition);
    }
}