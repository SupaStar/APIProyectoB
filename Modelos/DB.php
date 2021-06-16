<?php
require('vendor/autoload.php');
ini_set("display_errors", 1);
class BaseDatos
{
    public function conectar()
    {
        echo getcwd();
        $dotenv = Dotenv\Dotenv::createImmutable('./');
        $dotenv->load();
        $conn = mysqli_connect($_ENV['DBHOST'], $_ENV['DBUser'], $_ENV['DBPass'], $_ENV['DBName']);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        return $conn;
    }
}