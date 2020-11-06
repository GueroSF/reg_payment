<?php
declare(strict_types=1);

namespace App\Exception\LoginGate;


use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Throwable;

class LoginGateException extends AuthenticationException
{
    public function __construct($message = "", $code = 403, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
