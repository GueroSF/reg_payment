<?php
include $_SERVER['DOCUMENT_ROOT'].'/reg/includes/path.inc.php';
include $pathFileInc.'db_connect.inc.php';
include $pathFileInc.'error.inc.php';
$titleName = 'Главная';
include 'head_page.html.php';

$month = ['1'=>'Январь','Февраль','Март','Апрель', 'Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'];
$monthDisplay[0] = ["num"=>date('n_Y', strtotime('-2 month')), "name"=>$month[date('n', strtotime('-2 month'))],];
$monthDisplay[1] = ["num"=>date('n_Y', strtotime('-1 month')), "name"=>$month[date('n', strtotime('-1 month'))],];
$monthDisplay[2] = ["num"=>date('n_Y'), "name"=>$month[date('n')],];
$monthDisplay[3] = ["num"=>date('n_Y', strtotime('+1 month')), "name"=>$month[date('n', strtotime('+1 month'))],];

try {
	$sql = 'SELECT SUM(money) FROM payment WHERE payment_category = :category AND payment_for_month = :month';
	$result = $pdo->prepare($sql);
	for ($c=1;$c<4;$c++){
		$result->bindValue(':category', $c);
		for ($i=0;$i<4;$i++){
			$result->bindValue(':month', $monthDisplay[$i]['num']);
			$result->execute();
			$moneyCat[$c][] = $result->fetchCOLUMN();
		}
	}
} catch (PDOException $e) {
	errorMessage('Ошибка при подсчете сумм офф зарплаты');
}

//var_dump($moneyCat);

include 'first_page.html.php';