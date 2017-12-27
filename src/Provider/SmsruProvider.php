<?php

namespace Yamilovs\Bundle\SmsBundle\Provider;

use Yamilovs\Bundle\SmsBundle\Sms\SmsInterface;

class SmsruProvider implements ProviderInterface
{
    /**
     * @var string
     */
    private $apiId;

    /**
     * @var string
     */
    private $from;

    public function __construct(string $apiId, string $from)
    {
        $this->apiId = $apiId;
        $this->from = $from;
    }

    public function send(SmsInterface $sms)
    {
        // TODO: Implement send() method.
    }
}