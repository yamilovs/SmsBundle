<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\Tests\DependencyInjection\Compiler;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Yamilovs\Bundle\SmsBundle\DependencyInjection\Compiler\ProviderCompilerPass;
use Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider\AbstractProviderFactory;
use Yamilovs\Bundle\SmsBundle\Provider\SmsAeroProvider;
use Yamilovs\Bundle\SmsBundle\Provider\SmsCenterProvider;
use Yamilovs\Bundle\SmsBundle\Provider\SmsDiscountProvider;
use Yamilovs\Bundle\SmsBundle\Provider\SmsRuProvider;
use Yamilovs\Bundle\SmsBundle\Service\ProviderManager;

class ProviderCompilerPassTest extends TestCase
{
    protected function getProviderDefinition(string $class): Definition
    {
        return (new Definition($class))
            ->addTag(AbstractProviderFactory::SERVICE_TAG, ['provider' => $class]);
    }

    public function testThatCompilerPassProcessedProviders(): void
    {
        $container = new ContainerBuilder();

        $container->addDefinitions([
            ProviderManager::class => (new Definition(ProviderManager::class)),
            SmsRuProvider::class => $this->getProviderDefinition(SmsRuProvider::class),
            SmsCenterProvider::class => $this->getProviderDefinition(SmsCenterProvider::class),
            SmsDiscountProvider::class => $this->getProviderDefinition(SmsDiscountProvider::class),
            SmsAeroProvider::class => $this->getProviderDefinition(SmsAeroProvider::class),
        ]);

        (new ProviderCompilerPass())->process($container);

        $service = $container->get(ProviderManager::class);

        $this->assertInstanceOf(SmsRuProvider::class, $service->getProvider(SmsRuProvider::class));
        $this->assertInstanceOf(SmsCenterProvider::class, $service->getProvider(SmsCenterProvider::class));
        $this->assertInstanceOf(SmsDiscountProvider::class, $service->getProvider(SmsDiscountProvider::class));
        $this->assertInstanceOf(SmsAeroProvider::class, $service->getProvider(SmsAeroProvider::class));
    }

    public function testIfFactoryServiceDoesNotExist(): void
    {
        $container = new ContainerBuilder();

        $this->assertNull((new ProviderCompilerPass())->process($container));
    }
}