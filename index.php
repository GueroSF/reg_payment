<?php
include $_SERVER['DOCUMENT_ROOT'].'reg/includes/path.inc.php';
include $pathFileInc.'db_connect.inc.php';
include $pathFileInc.'error.inc.php';
$month = ['1'=>'Январь','Февраль','Март','Апрель', 'Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'];
$month2Last = ["num"=>date('n_Y', strtotime('-2 month')), "name"=>$month[date('n', strtotime('-2 month'))],];
$month1Last = ["num"=>date('n_Y', strtotime('-1 month')), "name"=>$month[date('n', strtotime('-1 month'))],];
$monthToday = ["num"=>date('n_Y'), "name"=>$month[date('n')],];
$monthNext = ["num"=>date('n_Y', strtotime('+1 month')), "name"=>$month[date('n', strtotime('+1 month'))],];

try {
	$sql = 'SELECT SUM(money) FROM accounting WHERE payment_category = 1 AND payment_for_month = :month';
	
} catch (PDOException $e) {
	
}


include 'first_page.html.php';