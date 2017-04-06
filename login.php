<?php
include 'setting_path_inc.php';
function was_login()
{
	if(session_status()!=2)session_start();
	if (isset($_SESSION['loggedIn']))
		return true;
	else {
		unset($_SESSION['loggedIn']);
		session_destroy();
		return false;
	}
}
if (isset($_POST['action'])&&$_POST['action']=='login'){
	$pass = md5($_POST['pass']);
	try {
		$sql = 'SELECT COUNT(*), id FROM user WHERE name = :name AND pass = :pass';
		$r = $pdo->prepare($sql);
		$r -> bindValue(':name', $_POST['name']);
		$r -> bindValue('pass', $pass);
		$r -> execute();
	} catch (PDOException $e) {
		errorMessage('Ошибка индетификации пользователя');
	}
	$user = $r->fetch();
	if ($user[0] == 1&&$user[1]==2){
		session_start();
		$_SESSION['loggedIn'] = true;
		$_SESSION['buh'] = true;
		header('Location:'.$pathURL);
	} elseif ($user[0] == 1&&$user[1]!=2){
		session_start();
		$_SESSION['loggedIn'] = true;
		header('Location:'.$pathURL);
	} else {
		if(session_status()!=2)session_start();
		unset($_SESSION['loggedIn']);
		unset($_SESSION['buh']);
		session_destroy();
		unset($_POST['pass']);
		unset($_POST['name']);
		$error = "Неверный логин или пароль";
		include $pathFileInc.'error.html.php';
		exit;
	}
}
if (isset($_GET['logOut'])&&$_GET['logOut']=='exit'){
	if(session_status()!=2)session_start();
	unset($_SESSION['loggedIn']);
	unset($_SESSION['buh']);
	session_destroy();
	header('Location:'.$pathURL);
	exit;
}