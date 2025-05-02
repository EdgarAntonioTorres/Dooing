<?php

// Prevenir la salida de buffer
ob_start();

require_once __DIR__ . '/../vendor/autoload.php';

// Inicializar las clases necesarias manualmente
require_once __DIR__ . '/../clases/Conexion.php';
require_once __DIR__ . '/../clases/Auth.php';
require_once __DIR__ . '/../clases/Task.php';

// Configuración especial para PHPUnit
// Evita problemas con headers y session_start()
// https://phpunit.de/manual/6.5/en/test-doubles.html
if (PHP_SAPI === 'cli') {
    // En ejecución CLI (como PHPUnit), simular sesiones sin iniciarlas realmente
    if (!isset($_SESSION)) {
        $_SESSION = [];
    }
} else {
    // En entorno web normal, iniciar sesión si no está activa
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}