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
		$dsn = 'mysql:dbname=test_db;host=172.19.0.2;charset=utf8';

		try{
			return new \PDO($dsn,$username,$password,$options);
		} catch (\PDOException $e){
		    echo '<pre>';
		    var_dump($e->getMessage());
		    echo '</pre>';
		    exit;
		}
	}
}