<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\Tests\DependencyInjection\Factory\Provider;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Builder\BooleanNodeDefinition;
use Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition;
use Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider\SmsCenterProviderFactory;
use Yamilovs\Bundle\SmsBundle\Provider\SmsCenterProvider;

class SmsCenterProviderFactoryTest extends TestCase
{
    use ProviderTestTrait;

    public function testGetCorrectName(): void
    {
        $this->assertEquals('sms_center', (new SmsCenterProviderFactory())->getName());
    }

    public function testConfigurationHasAllRequiredParameters(): void
    {
        $def = $this->getFactoryConfiguration(new SmsCenterProviderFactory());

        $this->assertArrayHasKey('login', $def);
        $this->assertArrayHasKey('password', $def);
        $this->assertArrayHasKey('sender', $def);
        $this->assertArrayHasKey('flash', $def);
    }

    public function testConfigurationHasCorrectTypes(): void
    {
        $def = $this->getFactoryConfiguration(new SmsCenterProviderFactory());

        $this->assertInstanceOf(ScalarNodeDefinition::class, $def['login']);
        $this->assertInstanceOf(ScalarNodeDefinition::class, $def['password']);
        $this->assertInstanceOf(ScalarNodeDefinition::class, $def['sender']);
        $this->assertInstanceOf(BooleanNodeDefinition::class, $def['flash']);
    }

    public function testThatDefinitionHasAllRequiredMethods(): void
    {
        $prototypeMethods = $this->getPrototypeMethods(new SmsCenterProvider());
        $calls = $this->getDefinitionMethodCalls(new SmsCenterProviderFactory(), ['login', 'password', 'sender', 'flash']);

        foreach ($calls as $call) {
            $this->assertContains($call, $prototypeMethods);
        }
    }
}