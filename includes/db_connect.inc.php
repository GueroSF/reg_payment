<?php
try {
	$pdo = new PDO('mysql:host=localhost;dbname=name','user','pass');
	$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo -> exec('SET NAMES "utf8"');
} catch (PDOException $e) {
	$error = 'Ошибка соединения с БД'.$e -> GetMessage();
	include 'error.html.php';
	exit();
}