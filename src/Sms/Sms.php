<?php

namespace Yamilovs\Bundle\SmsBundle\Sms;

class Sms implements SmsInterface
{
    /**
     * @var string
     */
    private $phoneNumber;

    /**
     * @var string
     */
    private $message;

    /**
     * @var bool
     */
    private $isDelivered = false;

    public function __construct(string $phoneNumber = null, string $message = null)
    {
        $this->setPhoneNumber($phoneNumber);
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
     *
     * @return Sms
     */
    public function setMessage(string $message): Sms
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     *
     * @return Sms
     */
    public function setPhoneNumber(string $phoneNumber): Sms
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDelivered(): bool
    {
        return $this->isDelivered;
    }

    /**
     * @param bool $isDelivered
     *
     * @return Sms
     */
    public function setIsDelivered(bool $isDelivered): Sms
    {
        $this->isDelivered = $isDelivered;

        return $this;
    }
}