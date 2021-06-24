# Paso 1

## Instalar todas las dependencias con el comando:

```html
composer install
```

Si no se cuenta con composer instalar desde *[aqui][1]*

# Paso 2

## Crear archivo .env y modificarlo en base a tu BD, basado en el .env.example

# Paso 3

## Ejecutar el servidor

Se puede ejecutar el servidor de php con el siguiente comando

```html
php -S localhost:8000
```

# Adicionales

### Ejemplo de ruta sin data

Si se desea crear una ruta sin necesidad de mandarle datos, seria de la siguiente forma

```php
$router->get('/login', [Controlador::class, 'accion']);
```

### Ejemplo de creacion de una ruta con el middleware de jwt

Se creo un middleware basado en el header de barear token, el cual si se desea implementar en la ruta dentro de
index.php, seria de la siguiente forma

```php
$router->post('/ruta', function () use ($data) {
$middleware = new MiddlewareJwt();
$response = json_decode($middleware->getBearerToken());
if (!$response->estado) {
echo json_encode($response);
return;
}
call_user_func([Controllador::class, 'accion'], $data);
});
```

[1]: https://getcomposer.org/download/