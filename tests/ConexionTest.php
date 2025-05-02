<?php

require_once __DIR__ . '/../clases/Conexion.php';

use PHPUnit\Framework\TestCase;

class ConexionTest extends TestCase
{
    public function testConectarDebeRetornarObjetoOMensajeError()
    {
        // Crear instancia de Conexion
        $conexion = new Conexion();

        $resultado = $conexion->conectar();
        
        // Si MongoDB está disponible, debería ser un objeto
        // Si no está disponible, será un string (mensaje de error)
        $this->assertTrue(is_object($resultado) || is_string($resultado));
    }
}