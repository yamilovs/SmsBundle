<?php

namespace Yamilovs\Bundle\SmsBundle\Provider;

use Yamilovs\Bundle\SmsBundle\Sms\SmsInterface;

interface ProviderInterface
{
    public function send(SmsInterface $sms);
}