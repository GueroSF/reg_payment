<?php
/**
 * Created by PhpStorm.
 * Date: 24.09.18
 */

namespace src\components;


use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ServerRequestInterface;
use src\documents\User;

class Authentication
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var ServerRequestInterface
     */
    private $request;

    /**
     * Authentication constructor.
     * @param EntityManager $entityManager
     * @param ServerRequestInterface $request
     */
    public function __construct(EntityManager $entityManager, ServerRequestInterface $request)
    {
        $this->entityManager = $entityManager;
        $this->request = $request;
    }

    public function login(): bool
    {
        $name = $this->request->getParsedBody()['name'] ?? null;
        $pass = $this->request->getParsedBody()['pass'] ?? null;

        if ($name === null || $pass === null) {
            return false;
        }

        if ($this->findUser($name, $pass)) {
            $_SESSION['loggedIn'] = true;

            return true;
        }

        unset($_SESSION['loggedIn']);
        $GLOBALS['login']['error'] = "Неверный логин или пароль";

        return false;
    }

    public function wasLogin(): bool
    {
        return isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] !== true;
    }

    public function logout(): void
    {
        unset($_SESSION['loggedIn']);
    }

    private function findUser(string $name, string $pass): bool
    {

        $userRepo = $this->entityManager->getRepository(User::class);

        /** @var User $user */
        $user = $userRepo->findOneBy(['name' => $name]);

        if ($user === null) {
            return false;
        }

        return password_verify($pass, $user->getPass());
    }
}