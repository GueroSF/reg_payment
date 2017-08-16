<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 02.08.17
 * Time: 12:57
 */

use model\Url;
use model\User;

spl_autoload_register(function ($name) {
	$aNameClass = explode('\\',$name);
	switch ($aNameClass[0]){
		case ('view'):
		case ('model'):
			require_once 'models/'.$aNameClass[1].'.php';
			break;
	}
});
$oUser = new User();
session_start();
if (!$oUser->was_login()) {
    (new \model\ViewLoginForm())->render();
    exit;
}
if (isset($_GET['logOut'])){
    $oUser->logout();
}

Url::manager($_SERVER['REQUEST_URI']);