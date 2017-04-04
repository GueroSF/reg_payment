<?php
include $_SERVER['DOCUMENT_ROOT'].'/reg/includes/path.inc.php';
include $pathFileInc.'db_connect.inc.php';
include $pathFileInc.'error.inc.php';
$titleName = 'Платежи';
include 'head_page.html.php';
try {
	$r = $pdo->query('SELECT * FROM payment_category');
} catch (PDOException $e) {
	errorMessage('Ошибка получения списка категорий платежей');
}
$paymentCategory = $r->fetchALL(PDO::FETCH_ASSOC);
if (isset($_POST['month_payment'])&&$_POST['month_payment']=='edit'){
	$month = $_POST['month'];
	$monthName = $_POST['monthName'];
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
	//var_dump($paymentMonth);
	include 'payment_list.html.php';
	exit();
}
if (isset($_POST['action'])&&$_POST['action']=='paymentAdd') {
	$date = $_POST['date'];
	$money = round($_POST['money'], 2);
	$category = $_POST['category'];
	$month = $_POST['month'];
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
	header('Location:'.$pathURL.'index.php');
	exit();
}