<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 03.08.17
 * Time: 17:32
 */

namespace model;


trait ConnectDB
{



	public function getConnect()
	{
		$options = [
			\PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
		];

		$username = 'root';
		$password = '123';
		$dsn = 'mysql:dbname=my_new_reg;host=127.0.0.1;charset=utf8';

		try{
			$pdo = new \PDO($dsn,$username,$password,$options);
			return $pdo;
		} catch (\PDOException $e){
			$this->send($e,false);
			return false;
		}
	}
}