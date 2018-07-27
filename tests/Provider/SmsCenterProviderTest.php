<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\Tests\Provider;

use PHPUnit\Framework\TestCase;
use Yamilovs\Bundle\SmsBundle\Provider\SmsCenterProvider;

class SmsCenterProviderTest extends TestCase
{
    public function testThatSettersImplementsChainPattern(): void
    {
        $provider = (new SmsCenterProvider())
            ->setLogin('login')
            ->setPassword('password')
            ->setSender('sender')
            ->setFlash(true)
        ;

        $this->assertInstanceOf(SmsCenterProvider::class, $provider);
    }
}