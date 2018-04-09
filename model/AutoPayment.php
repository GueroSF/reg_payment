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

    CONST TABLE_NAME = '`buh_autopayment`';

    protected static function getLastTime()
    {
        $oPDO = self::getConnect();
        $r = $oPDO->query('SELECT max(created_at) FROM '.self::TABLE_NAME.' WHERE account_id = 2 AND category_id = 12');
        return (int) $r->fetchColumn();
    }

    protected static function inputTimePayment()
    {
        $oPDO = self::getConnect();
        $time = time();
        try {
            $oPDO ->exec('INSERT INTO '.self::TABLE_NAME.' (`account_id`, `category_id` ,`created_at`) VALUE (2,12,'.$time.')');
            return true;
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            return false;
        }
    }


    public static function run(){

        if (date('d')>10){
            $qTime = strtotime('10-'.date('m-Y'));
        } else {
            $qTime = strtotime('10-'.date('m-Y').' - 1 month');
        }

        $timeLastPayment = self::getLastTime();

        $qTimePlus30Days = $qTime+(60*60*24*30);

        if (!($qTime<$timeLastPayment&&$qTimePlus30Days>$timeLastPayment)){
//            echo 'ok';
//        } else {
            $oPayment = new Category(2);
            $oPayment->iCategoryId = 12;
            $oPayment->sComment = 'авто платеж';
            $oPayment->sMoney = 350;
            $oPayment->sDate = date('Y-m-d');
            $oPayment->iOperation = 1;
            if ($oPayment->addPayment(true)){
                self::inputTimePayment();
                $_SESSION['AutoPayment'] = true;
            }
        }
    }
}