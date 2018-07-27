<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\Tests\Provider;

use PHPUnit\Framework\TestCase;
use Yamilovs\Bundle\SmsBundle\Provider\SmsRuProvider;

class SmsRuProviderTest extends TestCase
{
    public function testThatSettersImplementsChainPattern(): void
    {
        $provider = (new SmsRuProvider())
            ->setApiId('id')
            ->setFrom('from')
            ->setTest(false)
        ;

        $this->assertInstanceOf(SmsRuProvider::class, $provider);
    }
}