<?php
namespace Models;
use Illuminate\Database\Capsule\Manager as Capsule;

class Database {

    function __construct() {
        date_default_timezone_set('America/Mexico_City');
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver' => DBDRIVER,
            'host' => DBHOST,
            'database' => DBNAME,
            'username' => DBUSER,
            'password' => DBPASS,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);
        $capsule->bootEloquent();
    }

}