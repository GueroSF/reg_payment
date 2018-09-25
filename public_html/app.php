<?php
/**
 * Created by PhpStorm.
 * Date: 06.04.18
 * Time: 17:25
 */

mb_internal_encoding('utf-8');

define('APP_DEV', true);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'index.php';