<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 05.09.17
 * Time: 13:56
 */

namespace model;


class AutoPayment
{
    use ConnectDB;
    use ErrorOutput;


    public static function run(){

        if (date('d')>10){
            $qTime = strtotime('10-'.date('m-Y'));
        } else {
            $qTime = strtotime('10-'.date('m-Y').' - 1 month');
        }

//запрос к бд где возвращается дата последнего платежа

        $timeLastPayment = $new2Time;

        $qTimePlus30Days = $qTime+(60*60*24*30);

        if ($qTime<$timeLastPayment&&$qTimePlus30Days>$timeLastPayment){
            echo 'ok';
        } else {
            $oPayment = new Category(2);
            $oPayment->iCategoryId = ;
            $oPayment->sComment = 'авто платеж';
            $oPayment->sMoney = 350;
            $oPayment->sDate = date('Y-m-d');
            $oPayment->iOperation = 1;
            if ($oPayment->addPayment(true)){

            }
        }
    }
}