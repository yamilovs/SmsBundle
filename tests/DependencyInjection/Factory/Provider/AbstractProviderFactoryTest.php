<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\Tests\DependencyInjection\Factory\Provider;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider\AbstractProviderFactory;
use Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider\ProviderFactoryInterface;

class AbstractProviderFactoryTest extends TestCase
{
    protected function getSimpleProvider(): ProviderFactoryInterface
    {
        return new class extends AbstractProviderFactory
        {
            public function getName(): string {return '';}
            public function getDefinition(array $config): ChildDefinition {return new ChildDefinition('');}
            public function buildConfiguration(ArrayNodeDefinition $arrayNodeDefinition): void {}
        };
    }

    public function testThatContainerContainsProviderWithTag(): void
    {
        $provider = $this->getSimpleProvider();
        $container = new ContainerBuilder();

        $provider->setProviderDefinition($container, 'simple_provider_name', $provider->getDefinition([]));

        $this->assertTrue($container->has('yamilovs_sms.provider.simple_provider_name'));
        $this->assertEquals('yamilovs_sms.provider.simple_provider_name', key(
                $container->findTaggedServiceIds(AbstractProviderFactory::SERVICE_TAG))
        );
    }
}