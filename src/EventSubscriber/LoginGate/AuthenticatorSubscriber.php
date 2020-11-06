<?php
declare(strict_types=1);

namespace App\EventSubscriber\LoginGate;


use App\Exceptions\LoginGate\LoginGateException;
use App\Lib\ToastMessageType;
use App\Service\ToastManager;
use App\Service\LoginGate\Storage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;

class AuthenticatorSubscriber implements EventSubscriberInterface
{
    private Storage $storage;
    private RequestStack $requestStack;
    private ToastManager $toastManager;

    public function __construct(
        Storage $storage,
        RequestStack $requestStack,
        ToastManager $toastManager
    )
    {
        $this->storage = $storage;
        $this->requestStack = $requestStack;
        $this->toastManager = $toastManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            AuthenticationEvents::AUTHENTICATION_FAILURE => 'authFailure'
        ];
    }

    public function authFailure(AuthenticationFailureEvent $event): void
    {
        $exception = $event->getAuthenticationException();

        if ($exception instanceof LoginGateException) {
            return;
        }

        $request = $this->requestStack->getCurrentRequest();

        if (null === $ip = $request->getClientIp()) {
            return;
        }

        $username = $request->get('username', null);
        $username = null === $username ? 'no user' : $username;

        $this->toastManager->create('LoginGate', sprintf("ip: %s\nuser: %s", $ip, $username), ToastMessageType::INFO);
        $this->storage->incrementCountAttempts($ip, $username);
    }
}
