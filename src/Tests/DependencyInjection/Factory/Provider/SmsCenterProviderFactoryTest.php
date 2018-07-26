<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\Tests\DependencyInjection\Factory\Provider;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Builder\BooleanNodeDefinition;
use Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition;
use Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider\SmsCenterProviderFactory;

class SmsCenterProviderFactoryTest extends TestCase
{
    use ProviderConfigurationTestTrait;

    public function testGetCorrectName(): void
    {
        $this->assertEquals('sms_center', (new SmsCenterProviderFactory())->getName());
    }

    public function testConfigurationHasAllRequiredParameters(): void
    {
        $def = $this->getProviderDefinitions(new SmsCenterProviderFactory());

        $this->assertArrayHasKey('login', $def);
        $this->assertArrayHasKey('password', $def);
        $this->assertArrayHasKey('sender', $def);
        $this->assertArrayHasKey('flash', $def);
    }

    public function testConfigurationHasCorrectTypes(): void
    {
        $def = $this->getProviderDefinitions(new SmsCenterProviderFactory());

        $this->assertInstanceOf(ScalarNodeDefinition::class, $def['login']);
        $this->assertInstanceOf(ScalarNodeDefinition::class, $def['password']);
        $this->assertInstanceOf(ScalarNodeDefinition::class, $def['sender']);
        $this->assertInstanceOf(BooleanNodeDefinition::class, $def['flash']);
    }

    public function testThatDefinitionHasOrderedRequiredArguments(): void
    {
        $arg = ['login', 'password', 'sender', 'flash'];
        $def = (new SmsCenterProviderFactory())->getDefinition(array_flip($arg));

        $this->assertEquals(array_keys($arg), $def->getArguments());
    }
}