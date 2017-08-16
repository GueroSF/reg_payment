<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 16.08.17
 * Time: 16:12
 */

namespace model;


class Url
{
    public static function homeUrl()
    {
        return 'http://'.$_SERVER['HTTP_HOST'];
    }

    public static function manager($url){
        $aRawUrl = explode('/',$url);
        if (count($aRawUrl)>5) header("Location: ".self::homeUrl());
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
                $oCategory = new ViewCategory($aRawUrl[2]);
                if (isset($aRawUrl[3])&&$aRawUrl[3]=='category'){
                    if (empty($aRawUrl[4])) {
                        unset($aRawUrl[3]);
                        echo "<pre>";
                        var_dump($aRawUrl);
                        echo "</pre>";
                        $newUrl = implode('/',$aRawUrl);
                        header("Location: $newUrl");
                    }
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
}