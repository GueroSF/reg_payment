<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 03.08.17
 * Time: 17:31
 */

namespace model;


class User
{
	use ErrorOutput;
	use ConnectDB;

	public function login()
	{
		if (empty($_POST['pass'])||empty($_POST['name'])) return false;
		$pass = md5($_POST['pass']);
		try {
			$sql = 'SELECT COUNT(id), id FROM user WHERE name = :name AND pass = :pass GROUP BY id';
			$r = $this->getConnect()->prepare($sql);
			$r -> bindValue(':name', $_POST['name']);
			$r -> bindValue('pass', $pass);
			$r -> execute();
//			if ($r->fetchColumn() >=1) return true;
		} catch (\PDOException $e) {
			$this->send($e,false);
            return false;
//			errorMessage('Ошибка индетификации пользователя');
		}
        $user = $r->fetchColumn();
		echo "<pre>";
		var_dump($user);
		echo "</pre>";
        if ($user == 1){
            $_SESSION['loggedIn'] = true;
            return true;
        } else {
            unset($_SESSION['loggedIn']);
            unset($_POST['pass']);
            unset($_POST['name']);
            $GLOBALS['login']['error'] = "Неверный логин или пароль";
            session_destroy();
        }
		return false;
	}

	public function was_login()
	{
	    if (!isset($_SESSION['loggedIn'])||!$_SESSION['loggedIn']){
            return $this->login();
        }
        return true;
	}

	public function logout(){
        unset($_SESSION['loggedIn']);
        session_destroy();
        header('Location: .');
    }
}