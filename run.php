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
require_once 'config.php';

/*spl_autoload_register(function ($name) {
	$aNameClass = explode('\\',$name);
//	echo "<pre>";
//	var_dump($aNameClass);
//	echo "</pre>";
//	exit;
	switch ($aNameClass[0]){
		case ('view'):
		case ('model'):
		    if ($aNameClass[1]=='views'){
                require_once 'models/views/'.$aNameClass[2].'.php';
                break;
            }
			require_once 'models/'.$aNameClass[1].'.php';
			break;
	}
});*/

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
