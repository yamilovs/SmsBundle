<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\Exception;

class MessageBirdException extends \Exception
{
    public function __construct(int $code, string $description, string $parameter)
    {
        parent::__construct(sprintf('%u: %s. Parameter: %s.', $code, $description, $parameter), $code);
    }
}