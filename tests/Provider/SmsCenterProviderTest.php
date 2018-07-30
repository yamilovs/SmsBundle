<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\Tests\Provider;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Yamilovs\Bundle\SmsBundle\Exception\SmsCenterException;
use Yamilovs\Bundle\SmsBundle\Provider\SmsCenterProvider;
use Yamilovs\Bundle\SmsBundle\Sms\Sms;

class SmsCenterProviderTest extends TestCase
{
    use GuzzleClientTrait;

    public function testThatSettersImplementsChainPattern(): void
    {
        $provider = (new SmsCenterProvider())
            ->setLogin('login')
            ->setPassword('password')
            ->setSender('sender')
            ->setFlash(true)
            ->setClient(new Client())
        ;

        $this->assertInstanceOf(SmsCenterProvider::class, $provider);
    }

    public function testThatExceptionThrownOnInvalidResponseCode(): void
    {
        $this->expectException(SmsCenterException::class);

        (new SmsCenterProvider())
            ->setClient($this->getClientWithPreparedResponse(new Response(200, [], '{"error": "Nothing to do here", "error_code": 6}')))
            ->send(new Sms('+1234567890', 'Hello World'))
        ;
    }

    public function testSend(): void
    {
        $response = (new SmsCenterProvider())
            ->setClient($this->getClientWithPreparedResponse(new Response(200, [], '{"id": 1, "cnt": 1}')))
            ->send(new Sms('+1234567890', 'Hello World'))
        ;

        $this->assertTrue($response);
    }

    public function testSendWithAdditionalPostData(): void
    {
        $response = (new SmsCenterProvider())
            ->setSender('sender')
            ->setClient($this->getClientWithPreparedResponse(new Response(200, [], '{"id": 1, "cnt": 1}')))
            ->send(new Sms('+1234567890', 'Hello World'))
        ;

        $this->assertTrue($response);
    }
}