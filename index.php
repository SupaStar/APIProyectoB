<?php
require 'start.php';
require('Configuracion/JWT/Middleware.php');

use Controllers\UsuarioController;
use Middleware\MiddlewareJwt;

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data)) {
    $data = $_POST;
}

$router = new Router\Router('/usuario');

$router->post('/nuevoUsuario', function () use ($data) {
    call_user_func([UsuarioController::class, 'crearUsuario'], $data);
});
$router->post('/login', function () use ($data) {
    call_user_func([UsuarioController::class, 'login'], $data);
});

$router->add('/.*', function () {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    echo '<h1>404 - El sitio solicitado no existe</h1>';
});
//Ejemolo de uso con middleware

//$router->post('/nuevaApi', function () use ($data) {
//    $middleware = new MiddlewareJwt();
//    $response = json_decode($middleware->getBearerToken());
//    if (!$response->estado) {
//        echo json_encode($response);
//        return;
//    }
//    call_user_func([UsuarioController::class, 'nueva'], $data);
//});
$router->route();
?>