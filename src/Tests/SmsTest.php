<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\Tests;

use PHPUnit\Framework\TestCase;
use Yamilovs\Bundle\SmsBundle\Sms\Sms;

final class SmsTest extends TestCase
{
    public function testSmsWithoutRequiredParameters(): void
    {
        $this->expectException(\ArgumentCountError::class);

        new Sms();
    }

    public function testGetCorrectPhoneNumber(): void
    {
        $number = '+1234567890';
        $sms = new Sms($number, 'Hello world');

        $this->assertEquals($number, $sms->getPhoneNumber());
    }

    public function testGetCorrectMessage(): void
    {
        $message = 'Hello World';
        $sms = new Sms('+1234567890', $message);

        $this->assertEquals($message, $sms->getMessage());
    }

    public function testDateTimeEmptyParameter(): void
    {
        $sms = new Sms('+1234567890', 'Hello World', null);

        $dt = $sms->getDateTime();
        $ts = time();

        $this->assertInstanceOf(\DateTime::class, $dt);
        $this->assertEquals($ts, $dt->getTimestamp());
    }

    public function testGetCorrectDateTime(): void
    {
        $dt = (new \DateTime())->add(new \DateInterval('PT5M'));
        $sms = new Sms('+1234567890', 'Hello World', $dt);

        $this->assertEquals($dt, $sms->getDateTime());
    }
}