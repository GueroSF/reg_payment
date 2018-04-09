<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 02.08.17
 * Time: 12:57
 */

use model\Url;
use model\User;

require_once __DIR__ . '/vendor/autoload.php';

$oUser = new User();
session_start();
if (!$oUser->was_login()) {
    (new \model\views\ViewLoginForm())->render();
    exit;
}
if (isset($_GET['logOut'])) {
    $oUser->logout();
}

\model\AutoPayment::run();

Url::manager($_SERVER['REQUEST_URI']);