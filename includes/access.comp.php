<?php
function was_login()
{
	session_start();
	if (isset($_SESSION['loggedIn']))
		return true;
	else {
		unset($_SESSION['loggedIn']);
		session_destroy();
		return false;
	}
}
if(!was_login()){
	if(isset($_POST['action'])&&$_POST['action']=='login') return;
	$titleName = 'Вход';
	include 'head_page.html.php';
	include 'login.html.php';
	exit;
}
if (isset($_GET['logOut'])&&$_GET['logOut']=='exit'){
	session_start();
	unset($_SESSION['loggedIn']);
	unset($_SESSION['buh']);
	session_destroy();
	header('Location:'.$pathURL);
	exit;
}