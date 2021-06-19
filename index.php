<?php
require 'start.php';
require('Configuracion/JWT/Middleware.php');

use Controllers\ApiController;
use Controllers\UsuarioController;
use Middleware\MiddlewareJwt;

$router = new Router\Router('/api');

$router->post('/nuevoUsuario', [UsuarioController::class, 'crearUsuario']);
$router->post('/login', [UsuarioController::class, 'login']);

$router->post('/nuevaApi', function () {
    $middleware = new MiddlewareJwt();
    $response = json_decode($middleware->getBearerToken());
    if (!$response->estado) {
        echo json_encode($response);
        return;
    }
    call_user_func([ApiController::class, 'nueva']);
});

$router->get('/verApis', function () {
    $middleware = new MiddlewareJwt();
    $response = json_decode($middleware->getBearerToken());
    if (!$response->estado) {
        echo json_encode($response);
        return;
    }
    call_user_func([ApiController::class, 'todas']);
});

$router->get('/encontrar/([0-9]*)', function ($id) {
    $middleware = new MiddlewareJwt();
    $response = json_decode($middleware->getBearerToken());
    if (!$response->estado) {
        echo json_encode($response);
        return;
    }
    call_user_func([ApiController::class, 'encontrar'], $id);
});

$router->add('/.*', function () {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    echo '<h1>404 - El sitio solicitado no existe</h1>';
});


$router->route();
?>