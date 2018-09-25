<?php
/**
 * Created by PhpStorm.
 * Date: 24.09.18
 */

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

require_once __DIR__ .'/vendor/autoload.php';
require_once __DIR__ .'/config.php';


$dbParams = [
    'driver'   => 'pdo_mysql',
    'user'     => DB_NAME,
    'password' => DB_PWD,
    'dbname'   => DB_DBNAME,
    'host' => 'payment-mysql',
];

$config = Setup::createAnnotationMetadataConfiguration(
    [__DIR__ . '/src'],
    defined('APP_DEV'),
    null,
    null,
    false
);
$entityManager = EntityManager::create($dbParams, $config);

$request = \Zend\Diactoros\ServerRequestFactory::fromGlobals();