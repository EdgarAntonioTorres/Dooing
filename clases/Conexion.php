<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    class Conexion {
        public function conectar() {
            try {
                $servidor = getenv('MONGODB_HOST') ?: "127.0.0.1";
                $usuario = getenv('MONGODB_USER') ?: "mongoadmin";
                $password = getenv('MONGODB_PASSWORD') ?: "123456";
                $baseDatos = getenv('MONGODB_DATABASE') ?: "todo_app";
                $puerto = getenv('MONGODB_PORT') ?: "27017";
    
                $cadenaConexion = "mongodb://" .
                                    $usuario . ":" .
                                    $password . "@" .
                                    $servidor . ":" .
                                    $puerto . "/" .
                                    $baseDatos;
    
                $cliente = new MongoDB\Client($cadenaConexion);
                return $cliente->selectDatabase($baseDatos);
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }
    }
?>
