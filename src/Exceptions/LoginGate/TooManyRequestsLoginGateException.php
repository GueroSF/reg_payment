<?php
declare(strict_types=1);

namespace App\Exception\LoginGate;


use Throwable;

class TooManyRequestsLoginGateException extends LoginGateException
{
    public function __construct($message = 'Too many requests login', $code = 429, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
