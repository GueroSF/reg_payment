<?php
declare(strict_types=1);

namespace App\Service\LoginGate;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class LoginGate
{
    private Storage $storage;
    private RequestStack $requestStack;
    private int $maxAttempts;

    public function __construct(Storage $storage, RequestStack $requestStack, int $maxAttempts)
    {
        $this->storage = $storage;
        $this->requestStack = $requestStack;
        $this->maxAttempts = $maxAttempts;
    }

    public function canLogin(): bool
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        if (null === $ip = $request->getClientIp()) {
            return false;
        }

        return $this->storage->getCountAttemptsByIp($ip) < $this->maxAttempts;
    }
}
