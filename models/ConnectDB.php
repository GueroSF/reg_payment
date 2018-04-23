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



	public static function getConnect()
	{
		$options = [
			\PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
		];

		$username = DB_NAME;
		$password = DB_PWD;
		$dsn = DB_DSN;

		try{
			$pdo = new \PDO($dsn,$username,$password,$options);
			return $pdo;
		} catch (\PDOException $e){
//			$this->send($e,false);
			return false;
		}
	}
}