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
$validation->setMessages([
    'apellidos:required' => 'El campo apellidos es requerido',
    'nombre:required' => 'El campo nombre es requerido',
    'username:required' => 'El campo username es requerido',
    'mail:required' => 'El campo email es requerido',
    'mail:email' => 'El campo email no es un email valido',
    'password:required' => 'El password es requerido',
    'password:min' => 'El password debe contener minimo 8 caracteres',
    'rpassword:required' => 'La confirmacion de password es requerida',
    'rpassword:same' => 'La confirmacion de password no coincide',
]);
$validation->validate();
if ($validation->fails()) {
    $errores=$validation->errors();
    echo json_encode(["estado"=>false,"detalle"=>$errors = $errores->all()]);
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
    echo json_encode(["estado" => false, "detalle" => ["Usuario o correo repetido"]]);
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
