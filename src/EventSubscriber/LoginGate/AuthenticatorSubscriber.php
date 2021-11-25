<?php
declare(strict_types=1);

namespace App\EventSubscriber\LoginGate;

use App\Lib\ToastMessageType;
use App\Service\ToastManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\TooManyLoginAttemptsAuthenticationException;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;

class AuthenticatorSubscriber implements EventSubscriberInterface
{
    private ToastManager $toastManager;

    public function __construct(ToastManager $toastManager)
    {
        $this->toastManager = $toastManager;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LoginFailureEvent::class => 'authFailure',
        ];
    }

    public function authFailure(LoginFailureEvent $event): void
    {
        $exception = $event->getException();

        if (!$exception instanceof TooManyLoginAttemptsAuthenticationException) {
            return;
        }

        $request = $event->getRequest();

        if (null === $ip = $request->getClientIp()) {
            return;
        }

        $username = $request->get('_username', null);
        $username = null === $username ? 'no user' : $username;

        $this->toastManager->create('LoginGate', sprintf("ip: %s\nuser: %s", $ip, $username), ToastMessageType::INFO);
    }
}
