<?php

namespace Yamilovs\Bundle\SmsBundle\Exception;

class SmsruException extends \Exception
{
    /**
     * Map of error messages.
     * You can find more info at https://sms.ru/php
     *
     * @var array
     */
    private $codeDescriptionMap = [
        100 => 'The command was successful (or the message was accepted for sending)',
        101 => 'The message is sent to the provider',
        102 => 'Your message has been sent (along the way)',
        103 => 'Message delivered',
        104 => 'Message can not be delivered: lifetime has expired',
        105 => 'Message could not be delivered: deleted by provider',
        106 => 'Message could not be delivered: phone failed',
        107 => 'Message could not be delivered: unknown reason',
        108 => 'Message could not be delivered: rejected',
        130 => 'The message can not be delivered: the number of messages to this number per day has been exceeded',
        131 => 'The message can not be delivered: the number of identical messages to this number per minute has been exceeded',
        132 => 'The message can not be delivered: the number of identical messages to this number per day has been exceeded',
        200 => 'Invalid api_id',
        201 => 'There are not enough funds on the personal account',
        202 => 'Invalid recipient',
        203 => 'No message text',
        204 => 'The sender\'s name is not agreed with the administration',
        205 => 'The message is too long (more than 8 SMS)',
        206 => 'The daily limit for sending messages will be exceeded or exceeded',
        207 => 'You can not send messages to this number (or one of the numbers), or more than 100 numbers are listed in the list of recipients',
        208 => 'The time parameter is incorrect',
        209 => 'You added this number (or one of the numbers) to the stop list',
        210 => 'Used GET, where you need to use POST',
        211 => 'Method not found',
        212 => 'The text of the message must be sent in UTF-8 encoding (you sent it in a different encoding)',
        220 => 'The service is temporarily unavailable, try a little later.',
        230 => 'The total number of messages to this number per day has been exceeded.',
        231 => 'The limit of the same messages to this number per minute is exceeded.',
        232 => 'The limit of the same messages to this number per day has been exceeded.',
        300 => 'Invalid token (expired, or your IP has changed)',
        301 => 'Incorrect password or user not found',
        302 => 'The user is authorized, but the account is not confirmed (the user did not enter the code sent in the registration sms)',
    ];

    public function __construct(int $code = 0)
    {
        parent::__construct(sprintf('%u: %s', $code, $this->getCodeDescription($code)), $code);
    }

    private function getCodeDescription(int $code): string
    {
        return (key_exists($code, $this->codeDescriptionMap))
            ? $this->codeDescriptionMap[$code]
            : 'Unknown error';
    }
}