<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\Tests\Provider;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

trait GuzzleClientTrait
{
    protected function getClientWithPreparedResponse(Response $response): ClientInterface
    {
        return new Client([
            'handler' => HandlerStack::create(new MockHandler([$response]))
        ]);
    }
}