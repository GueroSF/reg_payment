<?php
include 'setting_path_inc.php';

if(!was_login()){
	$titleName = 'Вход';
	include 'head_page.html.php';
	include 'login.html.php';
	exit;
}

$titleName = 'Продукты/бензин';
include 'head_page.html.php';
if (isset($_POST['action'])&&$_POST['action']=='addPayment'){
	$month = $_POST['month'];
	$payment = $_POST['payment'];
	$date = $_POST['date'];
	$comm = $_POST['comment'];
	try {
		$sql = 'INSERT INTO `buh_product_oil` (`month`, `payment`, `comment`, `date_payment`) VALUES (:month,:pay,:comm,:date)';
		$insert = $pdo ->prepare($sql);
		$insert->bindValue(':month', $month);
		$insert->bindValue(':pay', $payment);
		$insert->bindValue(':comm', $comm);
		$insert->bindValue(':date', $date);
		$insert->execute();
	} catch (PDOException $e) {
		errorMessage('Ошибка при добавление платежа');
	}
}

$moneyMonth[0]['num'] = date('n_Y', strtotime('-1 month'));
$moneyMonth[1]['num'] = date('n_Y');
$moneyMonth[2]['num'] = date('n_Y', strtotime('+1 month'));

try {
	$sql = 'SELECT IFNULL(SUM(payment),0) FROM `buh_product_oil` WHERE `month` = :month';
	$result = $pdo->prepare($sql);
	for ($i=0;$i<3;$i++){
		$result->bindValue(':month', $moneyMonth[$i]['num']);
		$result->execute();
		$moneyMonth[$i]['sum'] = $result->fetchCOLUMN();
	}
} catch (PDOException $e) {
	errorMessage('Ошибка при подсчете сумм платежей зарплаты');
}
try {
	$sql = 'SELECT `id`, `payment`, `comment`, `date_payment` FROM `buh_product_oil` WHERE `month` = :month ORDER BY `date_payment` DESC';
	$result = $pdo->prepare($sql);
	for ($i=0;$i<3;$i++){
		$result->bindValue(':month', $moneyMonth[$i]['num']);
		$result->execute();
		$moneyMonth[$i]['payment'] = $result->fetchALL(PDO::FETCH_ASSOC);
	}
} catch (PDOException $e) {
	errorMessage('Ошибка получения платежей');
}

include 'product_oil.html.php';