<?php
require('vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable('./');
$dotenv->load();
defined("DBDRIVER") or define('DBDRIVER', $_ENV['DBDriver']);
defined("DBHOST") or define('DBHOST', $_ENV['DBHOST']);
defined("DBNAME") or define('DBNAME', $_ENV['DBName']);
defined("DBUSER") or define('DBUSER', $_ENV['DBUser']);
defined("DBPASS") or define('DBPASS', $_ENV['DBPass']);