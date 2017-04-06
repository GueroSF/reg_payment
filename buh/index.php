<?php
include 'setting_path_inc.php';

if(!was_login()){
	$titleName = 'Вход';
	include 'head_page.html.php';
	include 'login.html.php';
	exit;
}
if (isset($_GET['category'])&&isset($_GET['account'])){
	$idCat = $_GET['category'];
	$idAccount = $_GET['account'];
	try {
		$s = $pdo->query("SELECT * FROM `buh_category` WHERE `id` = $idCat");
	} catch (PDOException $e) {
		errorMessage('Ошибка получения name категории');
	}
	$category = $s->fetch(PDO::FETCH_ASSOC);
	$titleName = $category['name'];
	include 'head_page.html.php';
	try {
		$sql = 'SELECT `buh_transaction`.`id`,`name`, `money`,`date_operations` `date`
				FROM `buh_transaction`
				INNER JOIN buh_operation ON buh_operation.id = buh_transaction.`operations`
				WHERE `account` = :acc AND `category` = :cat
				ORDER BY `date_operations` DESC';
		$result = $pdo->prepare($sql);
		$result -> bindValue(':acc', $idAccount);
		$result -> bindValue(':cat', $idCat);
		$result -> execute();
	} catch (PDOException $e) {
		errorMessage('Ошибка получения инфо о платежах в категории');
	}
	$payments = $result->fetchALL(PDO::FETCH_ASSOC);
	//var_dump($payment);
	include 'payment_list.html.php';
	exit;
}

if (isset($_GET['account'])){
	$titleName = 'Категории';
	include 'head_page.html.php';
	$id = $_GET['account'];
	try {
		$s = $pdo->query("SELECT DISTINCT category id, name FROM `buh_transaction`
							INNER JOIN buh_category ON buh_category.id = buh_transaction.category
							WHERE `account` = $id");
	} catch (PDOException $e) {
		errorMessage('Ошибка получения категорий счета');
	}
	$categorys = $s->fetchALL(PDO::FETCH_ASSOC);
	try {
		$sql = 'SELECT `operations`, SUM(money) sum FROM `buh_transaction` WHERE `operations` = 1 AND `account` = :account AND `category` = :cat
			UNION ALL
			SELECT `operations`, SUM(money) sum FROM `buh_transaction` WHERE `operations` = 2 AND `account` = :account AND `category` = :cat';
		$result = $pdo->prepare($sql);
		foreach ($categorys as $key =>$cat) {
			$result -> bindValue(':account', $id);
			$result -> bindValue(':cat', $cat['id']);
			$result -> execute();
			$money= $result->fetchALL(PDO::FETCH_ASSOC);
			$categorys[$key]['sum'] = $money[0]['sum']-$money[1]['sum'];
		}
	} catch (PDOException $e) {
		errorMessage('Ошибка подсчета сумм категорий');
	}
	include 'category_page.html.php';
	exit;
}


$titleName = 'Счета';
include 'head_page.html.php';
try {
	$s = $pdo->query('SELECT * FROM buh_account');
} catch (PDOException $e) {
	errorMessage('Ошибка получения счетов');
}
$account = $s->fetchALL(PDO::FETCH_ASSOC);
try {
	$sql = 'SELECT `operations`, SUM(money) sum FROM `buh_transaction` WHERE `operations` = 1 AND `account` = :account 
			UNION ALL
			SELECT `operations`, SUM(money) sum FROM `buh_transaction` WHERE `operations` = 2 AND `account` = :account';
	$result = $pdo->prepare($sql);
	foreach ($account as $key => $value) {
		$result -> bindValue(':account', $value['id']);
		$result -> execute();
		$money = $result->fetchALL(PDO::FETCH_ASSOC);
		$account[$key]['sum'] = $money[0]['sum']-$money[1]['sum'];
	}
} catch (PDOException $e) {
	errorMessage('Ошибка при получении сумм счетов');
}
include 'account_page.html.php';