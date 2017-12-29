<?php

namespace Yamilovs\Bundle\SmsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider\AbstractProviderFactory;
use Yamilovs\Bundle\SmsBundle\Service\ProviderManager;

class ProviderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(ProviderManager::class)) {
            return;
        }

        $manager = $container->findDefinition(ProviderManager::class);
        $providers = $container->findTaggedServiceIds(AbstractProviderFactory::SERVICE_TAG);

        foreach ($providers as $id => $tags) {
            foreach ($tags as $attribute) {
                $manager->addMethodCall('addProvider', [
                    $attribute['provider'],
                    new Reference($id),
                ]);
            }
        }
    }
}