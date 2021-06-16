<?php
class BaseDatos
{
    private $servername = "localhost";
    private $database = "proyectob";
    private $username = "root";
    private $password = "";
    public function conectar()
    {
        $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->database);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        return $conn;
    }
}