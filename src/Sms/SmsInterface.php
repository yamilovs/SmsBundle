<?php

namespace Yamilovs\Bundle\SmsBundle\Sms;

interface SmsInterface
{
    public function getMessage(): string;

    public function setMessage(string $message): Sms;

    public function getPhoneNumber(): string;

    public function setPhoneNumber(string $phone): Sms;

    public function isDelivered();

    public function setIsDelivered(bool $isDelivered): Sms;
}