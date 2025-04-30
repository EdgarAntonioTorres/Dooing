<?php
class Conexion {
    private static $conexion;
    
    public static function conectar() {
        if (!isset(self::$conexion)) {
            try {
                $host = getenv('DB_HOST') ?: 'localhost';
                $puerto = getenv('DB_PORT') ?: '27017';
                $usuario = getenv('DB_USERNAME') ?: 'mongoadmin';
                $password = getenv('DB_PASSWORD') ?: '123456';
                $db = getenv('DB_DATABASE') ?: 'todo_app_test';
                
                $cadenaConexion = "mongodb://$usuario:$password@$host:$puerto/$db";
                
                $cliente = new \MongoDB\Client($cadenaConexion);
                self::$conexion = $cliente->selectDatabase($db);
                
                return self::$conexion;
            } catch (\Exception $e) {
                throw new \Exception("Error de conexión: " . $e->getMessage());
            }
        }
        return self::$conexion;
    }
}