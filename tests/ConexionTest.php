<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\TestableConexion;

class ConexionTest extends TestCase
{
    protected function tearDown(): void
    {
        // Reiniciar el estado después de cada prueba
        TestableConexion::resetTestState();
    }
    
    /**
     * Test para verificar que la conexión retorna un objeto MongoDB
     */
    public function testConexionRetornaObjetoMongoDB()
    {
        // Configurar la conexión de prueba
        $mockConnection = (object)['tareas' => (object)[], 'usuarios' => (object)[]];
        TestableConexion::setTestConnection($mockConnection);
        
        // Obtener la conexión
        $resultado = TestableConexion::conectar();
        
        // Verificar
        $this->assertIsObject($resultado);
        $this->assertObjectHasProperty('tareas', $resultado);
        $this->assertObjectHasProperty('usuarios', $resultado);
    }
    
    /**
     * Test para verificar que la conexión maneja errores
     */
    public function testConexionManejaErrores()
    {
        // Configurar para lanzar una excepción
        TestableConexion::setShouldThrowException(true);
        
        // Esperar excepción
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Error de conexión');
        
        // Intentar conectar - debería lanzar excepción
        TestableConexion::conectar();
    }
}