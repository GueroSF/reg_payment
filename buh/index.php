<?php
include 'setting_path_inc.php';

if(!was_login()){
	$titleName = 'Вход';
	include 'head_page.html.php';
	include 'login.html.php';
	exit;
}
if (isset($_POST['action'])&&$_POST['action']=='paymentAdd'){
	$idAcc = $_POST['account'];
	$idCat = $_POST['category'];
	$idOp = $_POST['operation'];
	$money = $_POST['money'];
	$date = $_POST['date'];
	$comm = $_POST['comment'];
	try {
		$sql = 'INSERT INTO `buh_transaction`(`account`, `operations`, `category`, `money`, `date_operations`) VALUES (:idAcc,:idOp,:idCat,:money,:date)';
		$insert = $pdo ->prepare($sql);
		$insert->bindValue(':idAcc', $idAcc);
		$insert->bindValue(':idOp', $idOp);
		$insert->bindValue(':idCat', $idCat);
		$insert->bindValue(':money', $money);
		$insert->bindValue(':date', $date);
		$insert->execute();
	} catch (PDOException $e) {
		errorMessage('Ошибка при добавление платежа');
	}
	if(!empty($comm)){
		$lastId = $pdo -> lastInsertId();
		try {
			$sql = 'INSERT INTO `buh_comment_payment`(`transaction_id`, `comment`) VALUES (:id, :text)';
			$insert = $pdo ->prepare($sql);
			$insert->bindValue(':id', $lastId);
			$insert->bindValue(':text', $comm);
			$insert->execute();
		} catch (PDOException $e) {
			errorMessage('Ошибка при добавлении комментария к платежу');
		}
	}
	$url = $_SERVER['HTTP_REFERER'];
	header("Location: $url");
	exit();
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
	try {
		$s = $pdo->query('SELECT * FROM `buh_operation`');
	} catch (PDOException $e) {
		errorMessage('Ошибка получения вида операций');
	}
	$operations = $s->fetchALL(PDO::FETCH_ASSOC);
	$titleName = $category['name'];
	include 'head_page.html.php';
	try {
		$sql = 'SELECT IFNULL(SUM(money),0) - (SELECT IFNULL(SUM(money),0) FROM `buh_transaction` WHERE `operations` = 2 AND `account` = :account AND `category` = :cat) sum FROM `buh_transaction` WHERE `operations` = 1 AND `account` = :account AND `category` = :cat';
		$result = $pdo->prepare($sql);
		$result -> bindValue(':account', $idAccount);
		$result -> bindValue(':cat', $idCat);
		$result -> execute();
	} catch (PDOException $e) {
		errorMessage('Ошибка подсчета сумм категорий');
	}
	$moneySumCat = $result->fetchCOLUMN();
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
		$sql = 'SELECT IFNULL(SUM(money),0) - (SELECT IFNULL(SUM(money),0) FROM `buh_transaction` WHERE `operations` = 2 AND `account` = :account AND `category` = :cat) sum FROM `buh_transaction` WHERE `operations` = 1 AND `account` = :account AND `category` = :cat';
		$result = $pdo->prepare($sql);
		foreach ($categorys as $key =>$cat) {
			$result -> bindValue(':account', $id);
			$result -> bindValue(':cat', $cat['id']);
			$result -> execute();
			$categorys[$key]['sum'] = $result->fetchCOLUMN();
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
	$sql = 'SELECT IFNULL(SUM(money),0) - (SELECT IFNULL(SUM(money),0) FROM `buh_transaction` WHERE `operations` = 2 AND `account` = :account) sum FROM `buh_transaction` WHERE `operations` = 1 AND `account` = :account';
	$result = $pdo->prepare($sql);
	foreach ($account as $key => $value) {
		$result -> bindValue(':account', $value['id']);
		$result -> execute();
		$account[$key]['sum'] = $result->fetchCOLUMN();
	}
} catch (PDOException $e) {
	errorMessage('Ошибка при получении сумм счетов');
}
include 'account_page.html.php';