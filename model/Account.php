<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 02.08.17
 * Time: 13:01
 */

namespace model;


class Account
{
	use ErrorOutput;
	use ConnectDB;

	/**
	 * Получение наименования всех счетов
	 * @return array|bool
	 */
	public static function getAccountName($id = false)
	{
		try {
			$s = self::getConnect()->query('SELECT * FROM buh_account');
			$aAccountInfo = $s->fetchALL();
		} catch (\PDOException $e) {
			self::send($e,false);
			return false;
//			errorMessage('Ошибка получения счетов');
		}
        if (is_numeric($id)){
		    return $aAccountInfo[$id];
        }
        return $aAccountInfo;
	}

	/**
	 * Получение наименования счета по его id
	 *
	 * @param $id
	 * @return bool|mixed
	 */
	public function selectAccount($id)
	{
		if (!is_numeric($id)) return false;
		try {
			$s = $this->getConnect()->query("SELECT name FROM buh_account WHERE id = $id");
			return $s->fetchCOLUMN();
		} catch (\PDOException $e) {
			$this->send($e,false);
			return false;
//			errorMessage('Ошибка получения счетов');
		}
	}

	/**
	 * Получение суммы всех счетов
	 *
	 * @return array|bool
	 */
	public function getSumAllAccount(){
		$accounts = $this->getAccountName();
		try {
			$sql = 'SELECT IFNULL(SUM(money),0) - (SELECT IFNULL(SUM(money),0) FROM `buh_transaction` WHERE `operations` = 2 AND `account` = :account) sum FROM `buh_transaction` WHERE `operations` = 1 AND `account` = :account';
			$result = $this->getConnect()->prepare($sql);
			foreach ($accounts as $key => $value) {
				$result -> bindValue(':account', $value['id']);
				$result -> execute();
				$accounts[$key]['sum'] = $result->fetchCOLUMN();
			}
			return $accounts;
		} catch (\PDOException $e) {
			$this->send($e,false);
			return false;
//			errorMessage('Ошибка при получении сумм счетов');
		}
	}

	/**
	 * Возвращает сумму заёмов по всем счетам
	 *
	 * @return bool|mixed
	 */
	public function getCredits()
	{
		try {
			$s = $this->getConnect()->query('SELECT IFNULL(SUM(money),0) - (SELECT IFNULL(SUM(money),0) FROM `buh_transaction` WHERE `operations` = 2 AND `category`= 5) sum FROM `buh_transaction` WHERE `operations` = 1 AND `category`= 5');
			return $s->fetchCOLUMN();
		} catch (\PDOException $e) {
			$this->send($e,false);
			return false;
//			errorMessage('Ошибка получения суммы заёма по всем счетам');
		}
	}

	/**
	 * Показывает средства внесенные
	 * на продуктовую карту
	 *
	 * @return bool|mixed
	 */
	public function getProductOil()
	{
		$todayMonth = date('n_Y', strtotime('-5 days'));
		try {
			$s = $this->getConnect()->query("SELECT SUM(payment) FROM `buh_product_oil` WHERE `month` = '$todayMonth'");
			return $s->fetchCOLUMN();
		} catch (\PDOException $e) {
			$this->send($e,false);
			return false;
//			errorMessage('Ошибка при подсчёте денег на продукты');
		}
	}


}