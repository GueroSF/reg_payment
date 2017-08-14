<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 02.08.17
 * Time: 12:57
 */

use view\ViewFirstPage;
use view\ViewProductOil;

spl_autoload_register(function ($name) {
	$aNameClass = explode('\\',$name);
	switch ($aNameClass[0]){
		case ('view'):
		case ('model'):
			require_once 'models/'.$aNameClass[1].'.php';
			break;
	}
});
$oUser = new \model\User();
session_start();
if (!$oUser->was_login()) {
    (new \view\ViewLoginForm())->render();
    exit;
}
if (isset($_GET['logOut'])){
    $oUser->logout();
}

function managerUrl()
{
	$aRawUrl = explode('/',$_SERVER['REQUEST_URI']);
	switch ($aRawUrl[1]){
		case ('product_oil'):
			(new ViewProductOil())->render();
			break;
		default:
			(new ViewFirstPage())->render();
	}
}

managerUrl();
