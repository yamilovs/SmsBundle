<?php

namespace Yamilovs\Bundle\SmsBundle\Tests\Fixture\Provider;

use Yamilovs\Bundle\SmsBundle\Provider\ProviderInterface;
use Yamilovs\Bundle\SmsBundle\Sms\SmsInterface;

class ProviderFixture
{
    public static function getProvider(): ProviderInterface
    {
        return new class implements ProviderInterface {
            public function send(SmsInterface $sms)
            {
                return true;
            }
        };
    }
}