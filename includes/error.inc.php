<?php
function errorMessage($text)
{
	global $e;
	$error = $text.$e -> GetMessage();
	include 'error.html.php';
	exit();
}