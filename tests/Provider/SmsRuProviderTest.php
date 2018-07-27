<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\Tests\Provider;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Yamilovs\Bundle\SmsBundle\Exception\SmsRuException;
use Yamilovs\Bundle\SmsBundle\Provider\SmsRuProvider;
use Yamilovs\Bundle\SmsBundle\Sms\Sms;

class SmsRuProviderTest extends TestCase
{
    use GuzzleClientTrait;

    public function testThatSettersImplementsChainPattern(): void
    {
        $provider = (new SmsRuProvider())
            ->setApiId('id')
            ->setFrom('from')
            ->setTest(false)
            ->setClient(new Client())
        ;

        $this->assertInstanceOf(SmsRuProvider::class, $provider);
    }

    public function testThatExceptionThrownOnInvalidResponseCode(): void
    {
        $this->expectException(SmsRuException::class);

        (new SmsRuProvider())
            ->setClient($this->getClientWithPreparedResponse(new Response(200, [], 302)))
            ->send(new Sms('+1234567890', 'Hello World'))
        ;
    }

    public function testSend(): void
    {
        $response = (new SmsRuProvider())
            ->setClient($this->getClientWithPreparedResponse(new Response(200, [], 100)))
            ->send(new Sms('+1234567890', 'Hello World'))
        ;

        $this->assertTrue($response);
    }
}