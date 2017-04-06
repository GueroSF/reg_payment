<?php
include 'setting_path_inc.php';

if(!was_login()){
	$titleName = 'Вход';
	include 'head_page.html.php';
	include 'login.html.php';
	exit;
}
if (isset($_SESSION['buh'])){
	header('Location: '.$pathURL.'buh/');
	exit;
}

$titleName = 'Главная';
include 'head_page.html.php';

$monthDisplay[0] = date('n_Y', strtotime('-2 month'));
$monthDisplay[1] = date('n_Y', strtotime('-1 month'));
$monthDisplay[2] = date('n_Y');
$monthDisplay[3] = date('n_Y', strtotime('+1 month'));

try {
	$sql = 'SELECT SUM(money) FROM payment WHERE payment_category = :category AND payment_for_month = :month';
	$result = $pdo->prepare($sql);
	for ($c=1;$c<4;$c++){
		$result->bindValue(':category', $c);
		for ($i=0;$i<4;$i++){
			$result->bindValue(':month', $monthDisplay[$i]);
			$result->execute();
			$moneyCat[$c][] = $result->fetchCOLUMN();
		}
	}
} catch (PDOException $e) {
	errorMessage('Ошибка при подсчете сумм платежей зарплаты');
}

//var_dump($moneyCat);

include 'first_page.html.php';