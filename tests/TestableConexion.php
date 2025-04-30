<?php
namespace Tests;

use App\Conexion;

class TestableConexion extends Conexion
{
    private static $testConnection = null;
    private static $shouldThrowException = false;
    
    public static function setTestConnection($connection)
    {
        self::$testConnection = $connection;
    }
    
    public static function setShouldThrowException($shouldThrow)
    {
        self::$shouldThrowException = $shouldThrow;
    }
    
    public static function conectar()
    {
        if (self::$shouldThrowException) {
            throw new \Exception("Error de conexión: Test exception");
        }
        
        return self::$testConnection ?: parent::conectar();
    }
    
    public static function resetTestState()
    {
        self::$testConnection = null;
        self::$shouldThrowException = false;
        
        // Also reset parent class static connection if needed
        $reflection = new \ReflectionClass(Conexion::class);
        $property = $reflection->getProperty('conexion');
        $property->setAccessible(true);
        $property->setValue(null, null);
    }
}