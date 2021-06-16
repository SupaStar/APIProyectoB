<?php
require_once('Modelos/DB.php');
require("Modelos/usuario.php");
require("JWT/config.php");
date_default_timezone_set('America/Mexico_City');
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data)) {
    $data = $_POST;
}
$username = $data['username'];
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
    if (password_verify($password, $usuario->password)){
        $JWT = new Auth();
        $token=$JWT->Generar($usuario);
        echo json_encode(["estado" => true, "detalle" => $token]);
        return;
    }
    echo json_encode(["estado" => false, "detalle" => "Usuario o password incorrectossss"]);
    return;
} else {
    echo json_encode(["estado" => false, "detalle" => "Usuario o password incorrectosaaaaa"]);
    return;
}