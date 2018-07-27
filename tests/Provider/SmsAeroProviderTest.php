<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\Tests\Provider;

use PHPUnit\Framework\TestCase;
use Yamilovs\Bundle\SmsBundle\Provider\SmsAeroProvider;

class SmsAeroProviderTest extends TestCase
{
    public function testThatSettersImplementsChainPattern(): void
    {
        $provider = (new SmsAeroProvider())
            ->setApiKey('key')
            ->setUser('user')
            ->setChannel('channel')
            ->setSign('sign')
        ;

        $this->assertInstanceOf(SmsAeroProvider::class, $provider);
    }
}