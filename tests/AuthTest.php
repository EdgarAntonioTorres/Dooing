<?php
require_once __DIR__ . '/../clases/Conexion.php';
require_once __DIR__ . '/../clases/Auth.php';

use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase
{
    private $auth;
    
    protected function setUp(): void
    {
        // Crear una instancia real de Auth
        $this->auth = new Auth();
        
        // En lugar de iniciar la sesión aquí, solo asegurarse de que $_SESSION exista
        if (!isset($_SESSION)) {
            $_SESSION = [];
        }
    }
    
    protected function tearDown(): void
    {
        // Limpiar sesión después de cada test
        $_SESSION = [];
    }
    
    public function testVerificarSesion()
    {
        // Caso: Sin sesión iniciada
        $_SESSION = [];
        $this->assertFalse($this->auth->verificarSesion());
        
        // Caso: Con sesión iniciada
        $_SESSION['usuario_id'] = '123';
        $this->assertTrue($this->auth->verificarSesion());
    }
    
    public function testCerrarSesion()
    {
        // Preparar
        $_SESSION['usuario_id'] = '123';
        $_SESSION['nombre'] = 'Test User';
        
        // Ejecutar
        $result = $this->auth->cerrarSesion();
        
        // Verificar
        $this->assertTrue($result);
        $this->assertEmpty($_SESSION);
    }
}