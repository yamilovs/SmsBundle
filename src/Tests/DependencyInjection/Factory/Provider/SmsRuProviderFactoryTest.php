<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\Tests\DependencyInjection\Factory\Provider;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Builder\BooleanNodeDefinition;
use Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition;
use Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider\SmsRuProviderFactory;

class SmsRuProviderFactoryTest extends TestCase
{
    use ProviderConfigurationTestTrait;

    public function testGetCorrectName(): void
    {
        $this->assertEquals('sms_ru', (new SmsRuProviderFactory())->getName());
    }

    public function testConfigurationHasAllRequiredParameters(): void
    {
        $def = $this->getProviderDefinitions(new SmsRuProviderFactory());

        $this->assertArrayHasKey('api_id', $def);
        $this->assertArrayHasKey('from', $def);
        $this->assertArrayHasKey('test', $def);
    }

    public function testConfigurationHasCorrectTypes(): void
    {
        $def = $this->getProviderDefinitions(new SmsRuProviderFactory());

        $this->assertInstanceOf(ScalarNodeDefinition::class, $def['api_id']);
        $this->assertInstanceOf(ScalarNodeDefinition::class, $def['from']);
        $this->assertInstanceOf(BooleanNodeDefinition::class, $def['test']);
    }
}