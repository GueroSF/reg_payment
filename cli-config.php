<?php
/**
 * Created by PhpStorm.
 * Date: 24.09.18
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . "/bootstrap.php";

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);