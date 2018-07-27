<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\Tests\Provider;

use PHPUnit\Framework\TestCase;
use Yamilovs\Bundle\SmsBundle\Provider\SmsDiscountProvider;

class SmsDiscountProviderTest extends TestCase
{
    public function testThatSettersImplementsChainPattern(): void
    {
        $provider = (new SmsDiscountProvider())
            ->setLogin('login')
            ->setPassword('password')
            ->setSender('sender')
            ->setFlash(true)
        ;

        $this->assertInstanceOf(SmsDiscountProvider::class, $provider);
    }
}