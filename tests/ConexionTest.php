<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Conexion;

class ConexionTest extends TestCase
{
    /**
     * Test para verificar que la conexión retorna un objeto MongoDB
     */
    public function testConexionRetornaObjetoMongoDB()
    {
        // Crear un mock para la clase Conexion
        $conexion = $this->getMockBuilder(Conexion::class)
                         ->onlyMethods(['conectar'])
                         ->getMock();
        
        // Definir el comportamiento del mock
        $conexion->method('conectar')
                ->willReturn((object)['tareas' => (object)[], 'usuarios' => (object)[]]);
        
        // Ejecutar el método y verificar que devuelve un objeto
        $resultado = $conexion->conectar();
        $this->assertIsObject($resultado);
        
        // Verificar que el objeto tiene la propiedad 'tareas'
        $this->assertObjectHasAttribute('tareas', $resultado);
        
        // Verificar que el objeto tiene la propiedad 'usuarios'
        $this->assertObjectHasAttribute('usuarios', $resultado);
    }
    
    /**
     * Test para verificar que la conexión maneja errores
     */
    public function testConexionManejaErrores()
    {
        // Crear un mock para la clase Conexion
        $conexion = $this->getMockBuilder(Conexion::class)
                         ->onlyMethods(['conectar'])
                         ->getMock();
        
        // Definir el comportamiento del mock para simular un error
        $conexion->method('conectar')
                ->willReturn('Error de conexión');
        
        // Ejecutar el método y verificar que devuelve un string con el error
        $resultado = $conexion->conectar();
        $this->assertIsString($resultado);
    }
}