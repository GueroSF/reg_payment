<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 02.08.17
 * Time: 12:57
 */

use model\Url;
use model\User;

require_once __DIR__ . '/bootstrap.php';

//$userRepository = $entityManager->getRepository(\src\documents\User::class);
//$users = $userRepository->findAll();
//
//foreach ($users as $user) {
//    var_export($user);
//}

//exit;

$auth = new \src\components\Authentication($entityManager);

session_start();
if (!$auth->wasLogin()) {
    (new \model\views\ViewLoginForm())->render();
    exit;
}
if (isset($_GET['logOut'])) {
    $auth->logout();
}

\model\AutoPayment::run();

Url::manager($_SERVER['REQUEST_URI']);
