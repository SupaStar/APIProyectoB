<?php

namespace Controllers;

use JwtAuth;
use Models\Usuario;
use Rakit\Validation\Validator;
class UsuarioController
{
    public static function crearUsuario($data)
    {
        $validator = new Validator;
        $validation = $validator->make($data, [
            'apellidos' => 'required',
            'nombre' => 'required',
            'mail' => 'required|email',
            'password' => 'required|min:8',
            'rpassword' => 'required|same:password',
        ]);
        $validation->setMessages([
            'apellidos:required' => 'El campo apellidos es requerido',
            'nombre:required' => 'El campo nombre es requerido',
            'mail:required' => 'El campo email es requerido',
            'mail:email' => 'El campo email no es un email valido',
            'password:required' => 'El password es requerido',
            'password:min' => 'El password debe contener minimo 8 caracteres',
            'rpassword:required' => 'La confirmacion de password es requerida',
            'rpassword:same' => 'La confirmacion de password no coincide',
        ]);
        $validation->validate();
        if ($validation->fails()) {
            $errores = $validation->errors();
            echo json_encode(["estado" => false, "detalle" => $errors = $errores->all()]);
            return;
        }
        $usuario = Usuario::where('email', $data['mail'])->first();
        if (isset($usuario)) {
            echo json_encode(["estado" => false, "detalle" => ["Usuario o correo repetido"]]);
            return;
        }
        $usuario = new Usuario();
        $usuario->apellidos = $data['apellidos'];
        $usuario->nombre = $data['nombre'];
        $usuario->email = $data['mail'];
        $usuario->password = password_hash($data['password'], PASSWORD_DEFAULT);
        $usuario->save();
        $JWT = new JwtAuth();
        $token = $JWT->Generar($usuario);
        echo json_encode(["estado" => true, 'detalle' => $token]);
    }

    public static function login($data)
    {
        $validator = new Validator;
        $validation = $validator->make($data, [
            'mail' => 'required|email',
            'password' => 'required',
        ]);
        $validation->setMessages([
            'mail:required' => 'El campo email es requerido',
            'mail:email' => 'El campo email no es un email valido',
            'password:required' => 'El password es requerido',
        ]);
        $validation->validate();
        if ($validation->fails()) {
            $errores = $validation->errors();
            echo json_encode(["estado" => false, "detalle" => $errors = $errores->all()]);
            return;
        }
        $usuario = Usuario::where('email', $data['mail'])->first();
        if (!isset($usuario)) {
            echo json_encode(["estado" => false, "detalle" => ["Correo o password incorrectos"]]);
            return;
        }
        if (password_verify($data['password'], $usuario->password)) {
            $JWT = new JwtAuth();
            $token = $JWT->Generar($usuario);
            echo json_encode(["estado" => true, "detalle" => $token]);
            return;
        }
        echo json_encode(["estado" => false, "detalle" => ["Correo o password incorrectos"]]);
        return;
    }
}

?>