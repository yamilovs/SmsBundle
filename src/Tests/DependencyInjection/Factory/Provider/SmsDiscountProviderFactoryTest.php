<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\Tests\DependencyInjection\Factory\Provider;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Builder\BooleanNodeDefinition;
use Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition;
use Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider\SmsCenterProviderFactory;
use Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider\SmsDiscountProviderFactory;
use Yamilovs\Bundle\SmsBundle\Provider\SmsDiscountProvider;

class SmsDiscountProviderFactoryTest extends TestCase
{
    use ProviderConfigurationTestTrait;

    public function testGetCorrectName(): void
    {
        $this->assertEquals('sms_discount', (new SmsDiscountProviderFactory())->getName());
    }

    public function testConfigurationHasAllRequiredParameters(): void
    {
        $def = $this->getProviderDefinitions(new SmsDiscountProviderFactory());

        $this->assertArrayHasKey('login', $def);
        $this->assertArrayHasKey('password', $def);
        $this->assertArrayHasKey('sender', $def);
        $this->assertArrayHasKey('flash', $def);
    }

    public function testConfigurationHasCorrectTypes(): void
    {
        $def = $this->getProviderDefinitions(new SmsDiscountProviderFactory());

        $this->assertInstanceOf(ScalarNodeDefinition::class, $def['login']);
        $this->assertInstanceOf(ScalarNodeDefinition::class, $def['password']);
        $this->assertInstanceOf(ScalarNodeDefinition::class, $def['sender']);
        $this->assertInstanceOf(BooleanNodeDefinition::class, $def['flash']);
    }

    public function testThatDefinitionHasOrderedRequiredArguments(): void
    {
        $arg = ['login', 'password', 'sender', 'flash'];
        $def = (new SmsDiscountProviderFactory())->getDefinition(array_flip($arg));

        $this->assertEquals(array_keys($arg), $def->getArguments());
    }
}