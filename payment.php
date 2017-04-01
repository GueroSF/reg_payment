<?php
include $_SERVER['DOCUMENT_ROOT'].'reg/includes/path.inc.php';
include $pathFileInc.'db_connect.inc.php';
include $pathFileInc.'error.inc.php';
if (isset($_POST['month_payment'])&&$_POST['month_payment']=='edit'){
	$month = $_POST['month'];
	try {
		$sql = 'SELECT p.money, c.name, p.payment_for_month pm, p.payment_date pd FROM payment p
				INNER JOIN payment_category c ON c.id = p.payment_category
				WHERE p.payment_for_month = :month';
		$r = $pdo -> prepare($sql);
		$r -> bindValue(':month', $month);
		$r -> execute();
	} catch (PDOException $e) {
		errorMessage('Ошибка при извлечении платежей за месяц');
	}
	$paymentMonth = $r->fetchALL();
	var_dump($paymentMonth);
}