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

		$username = 'test_user_name';
		$password = 'test_password';
		$dsn = 'mysql:dbname=test_db;host=172.19.0.3;charset=utf8';

		try{
			$pdo = new \PDO($dsn,$username,$password,$options);
			return $pdo;
		} catch (\PDOException $e){
//			$this->send($e,false);
			return false;
		}
	}
}