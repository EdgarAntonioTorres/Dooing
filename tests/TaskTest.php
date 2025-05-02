<?php

require_once __DIR__ . '/../clases/Conexion.php';
require_once __DIR__ . '/../clases/Task.php';

use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    private $task;
    
    protected function setUp(): void
    {
        // Crear una instancia real de Task
        $this->task = new Task();
        
        // En lugar de iniciar la sesión aquí, solo asegurarse de que $_SESSION exista
        if (!isset($_SESSION)) {
            $_SESSION = [];
        }
        
        // Simular sesión de usuario
        $_SESSION['usuario_id'] = '6123456789abcdef01234567';
    }
    
    protected function tearDown(): void
    {
        // Limpiar sesión después de cada test
        $_SESSION = [];
    }
    
    public function testMensajesTarea()
    {
        // Verificar mensajes según el tipo
        $this->assertStringContainsString('Tarea agregada', $this->task->mensajesTarea('insert'));
        $this->assertStringContainsString('Tarea actualizada', $this->task->mensajesTarea('update'));
        $this->assertStringContainsString('Tarea eliminada', $this->task->mensajesTarea('delete'));
        
        // Caso mensaje desconocido
        $this->assertEquals('', $this->task->mensajesTarea('unknown'));
    }
}