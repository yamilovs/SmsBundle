<?php

namespace Yamilovs\Bundle\SmsBundle\Sms;

abstract class AbstractSms implements SmsInterface
{
    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $message;

    public function __construct(string $phone = null, string $message = null)
    {
        $this->setPhone($phone);
        $this->setMessage($message);
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return AbstractSms
     */
    public function setMessage(string $message): AbstractSms
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return AbstractSms
     */
    public function setPhone(string $phone): AbstractSms
    {
        $this->phone = $phone;

        return $this;
    }
}