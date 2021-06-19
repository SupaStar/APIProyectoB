<?php
require('Modelos/DB.php');
require("Modelos/usuario.php");
require("JWT/config.php");
use Rakit\Validation\Validator;
require("Modelos/configuracionHttps.php");
date_default_timezone_set('America/Mexico_City');
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data)) {
    $data = $_POST;
}
$validator = new Validator;
$validation = $validator->make($data, [
    'apellidos'                  => 'required',
    'nombre'                  => 'required',
    'username'                  => 'required',
    'mail'                 => 'required|email',
    'password'              => 'required|min:8',
    'rpassword'      => 'required|same:password',
]);
$validation->validate();
if ($validation->fails()) {
    echo json_encode(["estado"=>false,"detalle"=>$errors = $validation->errors()]);
    return;
}
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
    $JWT = new Auth();
    $insert = $db->prepare("Insert into usuario values(null,?,?,?,?,?)");
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $momento = date('c');
    $insert->bind_param("sssss", $data['username'], $data['mail'], $password, $momento, $momento);
    $insert->execute();

    $select = $db->prepare("Select * from usuario where `username`=? OR email=?");
    $select->bind_param("ss", $data['username'], $data['mail']);
    $select->execute();
    $result = $select->get_result();
    $usuario = $result->fetch_object(Usuario::class);
    $token = $JWT->Generar($usuario);
    echo json_encode(["estado" => true, "detalle" => $token]);
}
