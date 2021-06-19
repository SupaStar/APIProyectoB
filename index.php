<?php
require 'start.php';

use Controllers\UsuarioController;

$router = new Router\Router('/usuario');

$router->post('/nuevoUsuario', [UsuarioController::class, 'crearUsuario']);
$router->post('/login', [UsuarioController::class, 'login']);

$router->add('/.*', function () {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    echo '<h1>404 - El sitio solicitado no existe</h1>';
});
//$router = new Router\Router('/prueba');
//$router->add('/pruebita', function (){
//    echo "putaaaaaaaaaaa";
//});
$router->route();
?>