<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\Tests\Provider;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Yamilovs\Bundle\SmsBundle\Exception\SmsDiscountException;
use Yamilovs\Bundle\SmsBundle\Provider\SmsDiscountProvider;
use Yamilovs\Bundle\SmsBundle\Sms\Sms;

class SmsDiscountProviderTest extends TestCase
{
    use GuzzleClientTrait;

    public function testThatSettersImplementsChainPattern(): void
    {
        $provider = (new SmsDiscountProvider())
            ->setLogin('login')
            ->setPassword('password')
            ->setSender('sender')
            ->setFlash(true)
            ->setClient(new Client())
        ;

        $this->assertInstanceOf(SmsDiscountProvider::class, $provider);
    }

    public function testThatExceptionThrownOnInvalidResponseCode(): void
    {
        $this->expectException(SmsDiscountException::class);

        (new SmsDiscountProvider())
            ->setClient($this->getClientWithPreparedResponse(new Response(200, [], 'invalid;foo')))
            ->send(new Sms('+1234567890', 'Hello World'))
        ;
    }

    public function testSend(): void
    {
        $response = (new SmsDiscountProvider())
            ->setClient($this->getClientWithPreparedResponse(new Response(200, [], 'accepted')))
            ->send(new Sms('+1234567890', 'Hello World'))
        ;

        $this->assertTrue($response);
    }

    public function testSendWithAdditionalPostData(): void
    {
        $response = (new SmsDiscountProvider())
            ->setSender('sender')
            ->setFlash(true)
            ->setClient($this->getClientWithPreparedResponse(new Response(200, [], 'accepted')))
            ->send(new Sms('+1234567890', 'Hello World'))
        ;

        $this->assertTrue($response);
    }
}