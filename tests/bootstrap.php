<?php
/**
 * Bootstrap para las pruebas
 * Este archivo se ejecuta antes de las pruebas
 */

// Requiere el autoloader de composer
require_once __DIR__ . '/../vendor/autoload.php';

// Si necesitamos configurar alguna variable de entorno o ambiente de prueba
$_ENV['APP_ENV'] = 'testing';

// Simulación de sesión para pruebas (si es necesario)
if (!isset($_SESSION)) {
    $_SESSION = [];
}

// Aquí podemos agregar cualquier otra configuración necesaria para las pruebas