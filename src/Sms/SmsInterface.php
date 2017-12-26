<?php

namespace Yamilovs\Bundle\SmsBundle\Sms;

interface SmsInterface
{
    public function getMessage(): string;

    public function setMessage(string $message): AbstractSms;

    public function getPhone(): string;

    public function setPhone(string $phone): AbstractSms;
}