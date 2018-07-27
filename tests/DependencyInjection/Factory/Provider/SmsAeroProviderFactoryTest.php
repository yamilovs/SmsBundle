<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\Tests\DependencyInjection\Factory\Provider;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition;
use Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider\SmsAeroProviderFactory;
use Yamilovs\Bundle\SmsBundle\Provider\SmsAeroProvider;

class SmsAeroProviderFactoryTest extends TestCase
{
    use ProviderTestTrait;

    public function testGetCorrectName(): void
    {
        $this->assertEquals('sms_aero', (new SmsAeroProviderFactory())->getName());
    }

    public function testConfigurationHasAllRequiredParameters(): void
    {
        $def = $this->getFactoryConfiguration(new SmsAeroProviderFactory());

        $this->assertArrayHasKey('user', $def);
        $this->assertArrayHasKey('api_key', $def);
        $this->assertArrayHasKey('sign', $def);
        $this->assertArrayHasKey('channel', $def);
    }

    public function testConfigurationHasCorrectTypes(): void
    {
        $def = $this->getFactoryConfiguration(new SmsAeroProviderFactory());

        $this->assertInstanceOf(ScalarNodeDefinition::class, $def['user']);
        $this->assertInstanceOf(ScalarNodeDefinition::class, $def['api_key']);
        $this->assertInstanceOf(ScalarNodeDefinition::class, $def['sign']);
        $this->assertInstanceOf(ScalarNodeDefinition::class, $def['channel']);
    }

    public function testThatDefinitionHasAllRequiredMethods(): void
    {
        $prototypeMethods = $this->getPrototypeMethods(new SmsAeroProvider());
        $calls = $this->getDefinitionMethodCalls(new SmsAeroProviderFactory(), ['user', 'api_key', 'sign', 'channel']);

        foreach ($calls as $call) {
            $this->assertContains($call, $prototypeMethods);
        }
    }
}