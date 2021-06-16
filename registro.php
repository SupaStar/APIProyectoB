<?php
require_once('DB.php');
require("Modelos/usuario.php");
date_default_timezone_set('America/Mexico_City');
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data)) {
    $data = $_POST;
}
$usuario = $data['username'];
$password = $data['password'];
$mail = $data['mail'];
$db = new BaseDatos();
$db = $db->conectar();
$select = $db->prepare("Select * from usuario where `username`=? OR email=?");
$select->bind_param("ss", $usuario, $mail);
$select->execute();
$result = $select->get_result();
$usuario = $result->fetch_object(Usuario::class);
if (isset($usuario)) {
    echo json_encode(["estado" => false, "detalle" => "Usuario o correo repetido"]);
} else {
    $insert = $db->prepare("Insert into usuario values(null,?,?,?,?,?)");
    $password = password_hash($password, PASSWORD_DEFAULT);
    $momento = date('c');
    $insert->bind_param("sssss", $usuario, $mail, $password, $momento, $momento);
    $insert->execute();
    echo json_encode(["estado" => true]);
}
