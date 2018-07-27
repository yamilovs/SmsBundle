<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Yamilovs\Bundle\SmsBundle\Provider\ProviderInterface;
use Yamilovs\Bundle\SmsBundle\Service\ProviderManager;
use Yamilovs\Bundle\SmsBundle\Sms\SmsInterface;

class ProviderManagerTest extends TestCase
{
    private function getProvider(): ProviderInterface
    {
        return new class implements ProviderInterface {
            public function send(SmsInterface $sms)
            {
                return true;
            }
        };
    }

    public function testGetNonExistProvider(): void
    {
        $this->expectException(\OutOfBoundsException::class);

        (new ProviderManager())->getProvider('NonExistProvider');
    }

    public function testSetWrongProviderType(): void
    {
        $this->expectException(\TypeError::class);

        (new ProviderManager())->addProvider('Foo', 'Bar');
    }

    public function testGetExistsProvider(): void
    {
        $provider = $this->getProvider();
        $name = 'TestProvider';
        $pm = new ProviderManager();

        $pm->addProvider($name, $provider);

        $this->assertEquals($provider, $pm->getProvider($name));
    }
}