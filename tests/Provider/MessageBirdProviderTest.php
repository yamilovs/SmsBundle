<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\Tests\Provider;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Yamilovs\Bundle\SmsBundle\Exception\MessageBirdException;
use Yamilovs\Bundle\SmsBundle\Provider\MessageBirdProvider;
use Yamilovs\Bundle\SmsBundle\Sms\Sms;

class MessageBirdProviderTest extends TestCase
{
    use GuzzleClientTrait;

    public function testThatSettersImplementsChainPattern(): void
    {
        $provider = (new MessageBirdProvider())
            ->setAccessKey('access_key')
            ->setOriginator('originator')
            ->setType('sms')
            ->setClient(new Client())
        ;

        $this->assertInstanceOf(MessageBirdProvider::class, $provider);
    }

    public function testThatExceptionThrownOnInvalidResponseCode(): void
    {
        $this->expectException(MessageBirdException::class);

        (new MessageBirdProvider())
            ->setClient($this->getClientWithPreparedResponse(new Response(422, [],
                '{"errors":[{"code": 2, "description": "Request not allowed (incorrect access_key)", "parameter": "access_key"}]}'
            )))
            ->send(new Sms('+1234567890', 'Hello World'))
        ;
    }

    public function testSend(): void
    {
        $response = (new MessageBirdProvider())
            ->setClient($this->getClientWithPreparedResponse(new Response(200, [])))
            ->send(new Sms('+1234567890', 'Hello World'))
        ;

        $this->assertTrue($response);
    }
}