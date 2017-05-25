<?php
include_once 'path.conf.php';
chdir(__DIR__);
/*
if(!was_login()){
	$titleName = 'Вход';
	include 'head_page.html.php';
	include 'login.html.php';
	exit;
}
*/
if (isset($_POST['action'])&&$_POST['action']=='paymentAdd') {
	if(empty($_POST['money'])||$_POST['money']==0){
		$error = 'Поле не может быть пустым или равняться нулю';
		include $pathFileInc.'error.html.php';
		exit;
	}
	$date = $_POST['date'];
	$money = $_POST['money'];
	$category = $_POST['category'];
	$month = $_REQUEST['month'];
	try {
		$sql = 'INSERT INTO payment SET
					money = :money,
					payment_category = :cat,
					payment_for_month = :pm,
					payment_date = :pd';
		$insert = $pdo ->prepare($sql);
		$insert->bindValue(':money', $money);
		$insert->bindValue(':cat', $category);
		$insert->bindValue(':pm', $month);
		$insert->bindValue(':pd', $date);
		$insert->execute();
	} catch (PDOException $e) {
		errorMessage('Ошибка при добавлении платежа');
	}
	$url = $_SERVER['HTTP_REFERER'];
	header("Location: $url");
	exit();
}
if (isset($_POST['action'])&&$_POST['action']=='paymentEdit') {
	if(empty($_POST['money'])||$_POST['money']==0){
		$error = 'Поле не может быть пустым или равняться нулю';
		include $pathFileInc.'error.html.php';
		exit;
	}
	try {
		$sql = 'UPDATE payment SET money = :money WHERE id = :id';
		$u = $pdo->prepare($sql);
		$u->bindValue(':money', $_POST['money']);
		$u->bindValue(':id', $_POST['id_payment']);
		$u->execute();
	} catch (PDOException $e) {
		errorMessage('Ошибка при обновлении платежа');
	}
	$url = $_SERVER['HTTP_REFERER'];
	header("Location: $url");
	exit;
}

$titleName = 'Платежи';
include 'head_page.html.php';
try {
	$r = $pdo->query('SELECT * FROM payment_category');
} catch (PDOException $e) {
	errorMessage('Ошибка получения списка категорий платежей');
}
$paymentCategory = $r->fetchALL(PDO::FETCH_ASSOC);
if (isset($_REQUEST['month'])){
	$month = $_REQUEST['month'];
	try {
		$sql = 'SELECT p.id, p.money, c.name, p.payment_date pd FROM payment p
				INNER JOIN payment_category c ON c.id = p.payment_category
				WHERE p.payment_for_month = :month';
		$r = $pdo -> prepare($sql);
		$r -> bindValue(':month', $month);
		$r -> execute();
	} catch (PDOException $e) {
		errorMessage('Ошибка при извлечении платежей за месяц');
	}
	$paymentMonth = $r->fetchALL(PDO::FETCH_ASSOC);
	include 'payment_list.html.php';
	exit();
}