<?php

namespace Controllers;

use Models\Api;
use Rakit\Validation\Validator;

class ApiController
{

    public static function nueva()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data)) {
            $data = $_POST;
        }
        $validator = new Validator;
        $validation = $validator->make($data, [
            'nombre' => 'required',
            'ruta' => 'required'
        ]);
        $validation->setMessages([
            'nombre:required' => 'El campo nombre es requerido',
            'ruta:required' => 'El campo ruta es requerido'
        ]);
        $validation->validate();
        if ($validation->fails()) {
            $errores = $validation->errors();
            echo json_encode(["estado" => false, "detalle" => $errors = $errores->all()]);
            return;
        }
        $api = Api::where('nombre', $data['nombre'])->first();
        if (isset($api)) {
            echo json_encode(["estado" => false, "detalle" => ["Api ya registrada"]]);
            return;
        }
        $api = new Api();
        $api->nombre = $data['nombre'];
        $api->ruta = $data['ruta'];
        $api->save();
        echo json_encode(["estado" => true, "detalle" => ["Api creada con exito"]]);
        return;
    }

    public static function todas()
    {
        $apis = Api::all();
        echo json_encode(["estado" => true, "detalle" => $apis]);
        return;
    }

    public static function encontrar($id)
    {
        $api = Api::find($id);
        if (isset($api)){
            echo json_encode(["estado" => true, "detalle" => $api]);
            return;
        }
        echo json_encode(["estado" => false, "detalle" => ['Sin resultados']]);
        return;
    }
}