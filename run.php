<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 02.08.17
 * Time: 12:57
 */

use model\Url;

require_once __DIR__ . '/bootstrap.php';


$auth = new \src\components\Authentication($entityManager, $request);
$loader = new Twig_Loader_Filesystem(__DIR__ . '/src/templates');
$twig = new Twig_Environment($loader);

session_start();
if (!$auth->wasLogin() && !$auth->login()) {

    session_destroy();

    echo $twig->render('login.html.twig');
    exit;
    (new \model\views\ViewLoginForm())->render();
    exit;
}
if (isset($request->getQueryParams()['logOut'])) {
    $auth->logout();
    session_destroy();
    header('Location: ' . Url::homeUrl());
    exit;
}

\model\AutoPayment::run();

$url = new Url($entityManager, $request);

$url->manager();
