<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 02.08.17
 * Time: 12:57
 */

use model\Category;
use model\User;
use model\ViewCategory;
use model\ViewFirstPage;
use model\ProductOil;
use model\ViewProductOil;

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

function managerUrl()
{
	$aRawUrl = explode('/',$_SERVER['REQUEST_URI']);
	switch ($aRawUrl[1]){
		case ('product_oil'):
		    $oViewProductOil = new ViewProductOil();
		    if (isset($_POST['action'])&&$_POST['action']=='addPayment'){
                if (!$oViewProductOil->addPayment()){
                    echo 'Какае-то ошибка';
                }
            }
			$oViewProductOil->render();
			break;
        case ('account'):
//            if (empty($aRawUrl[2])) continue;
            echo "<pre>";
//            var_dump($aRawUrl,$_SERVER);
            echo "</pre>";
            $oCategory = new ViewCategory($aRawUrl[2]);
            if (isset($aRawUrl[3])&&$aRawUrl[3]=='category'){
                $oCategory->iCategoryId = $aRawUrl[4];
                if (isset($_POST['action'])&&$_POST['action']=='addPayment'){
                    if (!$oCategory->addPayment()){
                        echo 'Какае-то ошибка';
                    }
                }
                $oCategory->render('payments');
                break;
            }
            $oCategory->render();
            break;
		default:
			(new ViewFirstPage())->render();
	}
}

managerUrl();
