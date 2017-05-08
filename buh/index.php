<?php
include 'setting_path_inc.php';

if(!was_login()){
	$titleName = 'Вход';
	include 'head_page.html.php';
	include 'login.html.php';
	exit;
}
function selectAccount($id = 0){
	if ($id === 0) {
		try {
			$s = $GLOBALS['pdo']->query('SELECT * FROM buh_account');
		} catch (PDOException $e) {
			errorMessage('Ошибка получения счетов');
		}
		return $s->fetchALL(PDO::FETCH_ASSOC);
	} else {
		try {
			$s = $GLOBALS['pdo']->query("SELECT name FROM buh_account WHERE id = $id");
		} catch (PDOException $e) {
			errorMessage('Ошибка получения счетов');
		}
		return $s->fetchCOLUMN();
	}	
}
function selectOper(){
	try {
		$s = $GLOBALS['pdo']->query('SELECT * FROM `buh_operation`');
	} catch (PDOException $e) {
		errorMessage('Ошибка получения вида операций');
	}
	return $s->fetchALL(PDO::FETCH_ASSOC);
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
if (isset($_POST['action'])&&$_POST['action']=='addCategory') {
	$idAcc = $_POST['account'];
	$nameCategory = $_POST['category'];
	$idOp = $_POST['operation'];
	$money = $_POST['money'];
	$date = $_POST['date'];
	$comm = $_POST['comment'];
	try {
		$sql = 'INSERT INTO `buh_category` SET `name` = :name';
		$insert = $pdo ->prepare($sql);
		$insert->bindValue(':name', $nameCategory);
		$insert->execute();
	} catch (PDOException $e) {
		errorMessage('Ошибка добавления категории');
	}
	$idCat = $pdo -> lastInsertId();
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
	$url = $pathURL."buh/?category=$idCat&account=$idAcc";
	header("Location: $url");
	exit();
}
if (isset($_GET['add'])) {
	$titleName = 'Добавить';
	include 'head_page.html.php';
	$accounts = selectAccount();
	$operations = selectOper();
	include 'add_category.html.php';
	exit;
}
if (isset($_GET['category'])&&isset($_GET['account'])){
	$idCat = $_GET['category'];
	$idAccount = $_GET['account'];
	$accountName = selectAccount($idAccount);
	try {
		$s = $pdo->query("SELECT * FROM `buh_category` WHERE `id` = $idCat");
	} catch (PDOException $e) {
		errorMessage('Ошибка получения name категории');
	}
	$category = $s->fetch(PDO::FETCH_ASSOC);
	$operations = selectOper();
	$titleName = $category['name'];
	include 'head_page.html.php';
	try {
		$sql = 'SELECT IFNULL(SUM(money),0) - (SELECT IFNULL(SUM(`money`),0) FROM `buh_transaction` WHERE `operations` = 2 AND `account` = :account AND `category` = :cat) sum FROM `buh_transaction` WHERE `operations` = 1 AND `account` = :account AND `category` = :cat';
		$result = $pdo->prepare($sql);
		$result -> bindValue(':account', $idAccount);
		$result -> bindValue(':cat', $idCat);
		$result -> execute();
	} catch (PDOException $e) {
		errorMessage('Ошибка подсчета сумм категорий');
	}
	$moneySumCat = $result->fetchCOLUMN();
	try {
		$sql = 'SELECT `buh_transaction`.`id`,`name`, `money`,`date_operations` `date`, IFNULL(`comment`,\'false\') `comm`
				FROM `buh_transaction`
				INNER JOIN buh_operation ON buh_operation.id = buh_transaction.`operations`
				LEFT JOIN `buh_comment_payment` ON `buh_comment_payment`.`transaction_id` = `buh_transaction`.`id`
				WHERE `account` = :acc AND `category` = :cat
				ORDER BY `date_operations` DESC ,`buh_transaction`.`id` DESC';
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
	$id = $_GET['account'];
	$accountName = selectAccount($id);
	include 'head_page.html.php';
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
$accounts = selectAccount();
try {
	$sql = 'SELECT IFNULL(SUM(money),0) - (SELECT IFNULL(SUM(money),0) FROM `buh_transaction` WHERE `operations` = 2 AND `account` = :account) sum FROM `buh_transaction` WHERE `operations` = 1 AND `account` = :account';
	$result = $pdo->prepare($sql);
	foreach ($accounts as $key => $value) {
		$result -> bindValue(':account', $value['id']);
		$result -> execute();
		$accounts[$key]['sum'] = $result->fetchCOLUMN();
	}
} catch (PDOException $e) {
	errorMessage('Ошибка при получении сумм счетов');
}
try {
	$s = $pdo->query('SELECT IFNULL(SUM(money),0) - (SELECT IFNULL(SUM(money),0) FROM `buh_transaction` WHERE `operations` = 2 AND `category`= 5) sum FROM `buh_transaction` WHERE `operations` = 1 AND `category`= 5');
} catch (PDOException $e) {
	errorMessage('Ошибка получения суммы заёма по всем счетам');
}
$category5 = $s->fetchCOLUMN();
$todayMonth = date('n_Y', strtotime('-8 days'));
try {
	$s = $pdo->query("SELECT SUM(payment) FROM `buh_product_oil` WHERE `month` = '$todayMonth'");
} catch (PDOException $e) {
	errorMessage('Ошибка при подсчёте денег на продукты');
}
$prOilSum = $s->fetchCOLUMN();
include 'account_page.html.php';