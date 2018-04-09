<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 16.08.17
 * Time: 16:12
 */

namespace model;


use model\views\ViewAddNewCategory;
use model\views\ViewCategory;
use model\views\ViewFirstPage;
use model\views\ViewProductOil;

class Url
{
    public static $btmBack = '.';

    public static function homeUrl()
    {
        return 'http://'.$_SERVER['HTTP_HOST'];
    }

    public static function manager($url){
        if (isset($_POST['action'])&&$_POST['action']=='addCategory'){
            Category::addNewCategory();
        }
        $aRawUrl = explode('/',$url);
//        if (count($aRawUrl)>5) header("Location: ".self::homeUrl());
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
                if (empty($aRawUrl[2])) header("Location: ".self::homeUrl());
                $oCategory = new ViewCategory($aRawUrl[2]);
                if (isset($aRawUrl[3])&&$aRawUrl[3]=='category'){
                    if (empty($aRawUrl[4])) header("Location: ".self::getNewUrl($aRawUrl,3));
                    $oCategory->iCategoryId = $aRawUrl[4];
                    if (isset($_POST['action'])&&$_POST['action']=='addPayment'){
                        if (!$oCategory->addPayment()){
                            echo 'Какае-то ошибка';
                        }
                    }
                    self::$btmBack = self::getNewUrl($aRawUrl,3);
                    $oCategory->render('payments');
                    break;
                } /*elseif (is_numeric($aRawUrl[3])) {
                    header("Location: ".self::homeUrl());
                }*/
                /** TODO добавить обработку не правильных адресов */
                self::$btmBack = '..';
                $oCategory->render();
                break;
            case ('category_add'):
                (new ViewAddNewCategory())->render();
                break;
            default:
                (new ViewFirstPage())->render();
                break;
        }
    }

    public static function getNewUrl(array $aUrl,int $key){
        array_splice($aUrl,$key);
        return rtrim(implode('/',$aUrl),'/');
    }
}