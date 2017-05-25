<?php
if (!isset($GLOBALS['e'])) global $e;
define('DOC_ROOT', '/');
define('_INCLUDES', DOC_ROOT.'includes/');
$pathURL = 'http://'.$_SERVER['HTTP_HOST'].'/';
include_once _INCLUDES.'db_connect.inc.php';
include_once _INCLUDES.'error.inc.php';
include_once _INCLUDES.'month_name.inc.php';
include_once _INCLUDES.'access.comp.php';
//include_once DOC_ROOT.'class/select.class.php';
//include_once DOC_ROOT.'class/payment.class.php';
//include_once DOC_ROOT.'class/contents_account.class.php';
//include_once DOC_ROOT.'class/account_category.class.php';