<?php

namespace Yamilovs\Bundle\SmsBundle\Exception;

class SmsCenterException extends \Exception
{
    /**
     * Map of error messages.
     * You can find more info at https://smsc.ru/api/http/send/sms/sms_answer/
     *
     * @var array
     */
    private $codeDescriptionMap = [
        1 => 'Error in the parameters.',
        2 => 'Wrong login or password.',
        3 => 'There is not enough money on the Customer\'s account.',
        4 => 'The IP address is temporarily blocked due to frequent errors in the requests.',
        5 => 'Invalid date format.',
        6 => 'The message is not allowed (by text or by the sender\'s name).',
        7 => 'Invalid phone number format.',
        8 => 'The message to the specified number can not be delivered.',
        9 => 'Sending more than one identical request to send an SMS message or more than five identical requests to receive the message\'s cost within a minute.',
    ];

    public function __construct(int $code)
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