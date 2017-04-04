<?php
include $_SERVER['DOCUMENT_ROOT'].'/reg/includes/path.inc.php';
include $pathFileInc.'db_connect.inc.php';
include_once $pathFileInc.'error.inc.php';
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
		$sql = 'SELECT COUNT(*) FROM user WHERE name = :name AND pass = :pass';
		$r = $pdo->prepare($sql);
		$r -> bindValue(':name', $_POST['name']);
		$r -> bindValue('pass', $pass);
		$r -> execute();
	} catch (PDOException $e) {
		errorMessage('Ошибка индетификации пользователя');
	}
	$count = $r->fetchCOLUMN();
	if ($count == 1){
		session_start();
		$_SESSION['loggedIn'] = true;
		header('Location:'.$pathURL);	
	} else {
		if(session_status()!=2)session_start();
		unset($_SESSION['loggedIn']);
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
	session_destroy();
	header('Location:'.$pathURL);
	exit;
}