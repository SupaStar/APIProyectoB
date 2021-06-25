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

# Interaccion con la Base de datos

En este proyecto se implemento eloquent, si necesitas informacion acerca de funciones puedes hacerlo
mediante *[el siguiente link][2]*

# Routeo

Si tu ru ruteo esta de la siguiente forma

```php
$router = new Router\Router('/api');
```

Tu ruta de acceso en postman o general, seria de la siguiente forma

```html
http://localhost:8000/api/tuRuta
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

[2]: https://laravel.com/docs/8.x/eloquent