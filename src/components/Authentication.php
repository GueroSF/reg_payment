<?php
/**
 * Created by PhpStorm.
 * Date: 24.09.18
 */

namespace src\components;


use Doctrine\ORM\EntityManager;
use src\documents\User;

class Authentication
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Authentication constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function login()
    {
        if (empty($_POST['pass']) || empty($_POST['name'])) {
            return false;
        }

        $name = $_POST['name'];
        $pass = md5($_POST['pass']);

        $userRepo = $this->entityManager->getRepository(User::class);

        $user = $userRepo->findOneBy(
            [
                'name' => $name,
                'pass' => $pass,
            ]
        );

        if ($user !== null) {
            $_SESSION['loggedIn'] = true;

            return true;
        }

        unset($_SESSION['loggedIn']);
        unset($_POST['pass']);
        unset($_POST['name']);
        $GLOBALS['login']['error'] = "Неверный логин или пароль";
        session_destroy();

        return false;
    }

    public function wasLogin()
    {
        if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
            return $this->login();
        }

        return true;
    }

    public function logout()
    {
        unset($_SESSION['loggedIn']);
        session_destroy();
        header('Location: .');
    }
}