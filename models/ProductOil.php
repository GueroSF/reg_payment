<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 03.08.17
 * Time: 17:22
 */

namespace model;


class ProductOil
{
	use ConnectDB;
	use ErrorOutput;


    /**
     * 3 месяца: текущий 1, и -+1
     *
     * @param bool $num
     * @return mixed
     */
	public function month($num = false){
        $aMoneyMonth[0]['num'] = date('n_Y', strtotime('-1 month'));
        $aMoneyMonth[1]['num'] = date('n_Y');
        $aMoneyMonth[2]['num'] = date('n_Y', strtotime('+1 month'));

        if ($num === false) return $aMoneyMonth;
        else return $aMoneyMonth[$num]['num'];
    }

    /**
     * Возвращает количество внеснных денег по месяцам и платежи
     *
     * @return mixed
     */
    public function getSum(){
        $aMoneyMonth = $this->month();
        try {
            $sql = 'SELECT IFNULL(SUM(payment),0) FROM `buh_product_oil` WHERE `month` = :month';
            $result = $this->getConnect()->prepare($sql);
            for ($i=0;$i<3;$i++){
                $result->bindValue(':month', $this->month($i));
                $result->execute();
                $aMoneyMonth[$i]['sum'] = $result->fetchCOLUMN();
            }
//            return $aMoneyMonth;
        } catch (\PDOException $e) {
            $this->send($e,false);
//            errorMessage('Ошибка при подсчете сумм платежей зарплаты');
        }
        try {
            $sql = 'SELECT `id`, `payment`, `comment`, `date_payment` FROM `buh_product_oil` WHERE `month` = :month ORDER BY `date_payment` DESC';
            $result = $this->getConnect()->prepare($sql);
            for ($i=0;$i<3;$i++){
                $result->bindValue(':month', $this->month($i));
                $result->execute();
                $aMoneyMonth[$i]['payment'] = $result->fetchALL();
            }
//            return $aMoneyMonth;
        } catch (\PDOException $e) {
            $this->send($e,false);
//            errorMessage('Ошибка получения платежей');
        }
        return $aMoneyMonth;
    }

    /**
     * Добавляет платеж
     *
     * @return bool
     */
    public function addPayment(){
        $month = $_POST['month'];
        $payment = $_POST['payment'];
        $date = $_POST['date'];
        $comm = $_POST['comment'];
        try {
            $sql = 'INSERT INTO `buh_product_oil` (`month`, `payment`, `comment`, `date_payment`) VALUES (:month,:pay,:comm,:date)';
            $insert = $this->getConnect()->prepare($sql);
            $insert->bindValue(':month', $month);
            $insert->bindValue(':pay', $payment);
            $insert->bindValue(':comm', $comm);
            $insert->bindValue(':date', $date);
            $insert->execute();
        } catch (\PDOException $e) {
            $this->send($e,false);
            return false;
//            errorMessage('Ошибка при добавление платежа');
        }
        return true;
    }
}