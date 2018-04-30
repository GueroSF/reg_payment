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
			return new \PDO($dsn,$username,$password,$options);
		} catch (\PDOException $e){
		    echo '<pre>';
		    var_dump($e->getMessage());
		    echo '</pre>';
		    exit;
		}
	}
}
