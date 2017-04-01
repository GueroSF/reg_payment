<?php
$month = ['1'=>'Январь','Февраль','Март','Апрель', 'Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'];
$month2Last = ["num"=>date('n_Y', strtotime('-2 month')), "name"=>$month[date('n', strtotime('-2 month'))],];
$month1Last = ["num"=>date('n_Y', strtotime('-1 month')), "name"=>$month[date('n', strtotime('-1 month'))],];
$monthToday = ["num"=>date('n_Y'), "name"=>$month[date('n')],];
$monthNext = ["num"=>date('n_Y', strtotime('+1 month')), "name"=>$month[date('n', strtotime('+1 month'))],];


include 'first_page.html.php';