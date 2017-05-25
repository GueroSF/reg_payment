<?php
function errorMessage($text){
	include 'setting_path_inc.php';
	global $e;
	$error = $text.$e -> GetMessage();
	include 'error.html.php';
	exit();
}