<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    class Conexion {
        public function conectar() {
            try {
                $servidor = "127.0.0.1";
                $usuario = "mongoadmin";
                $password = "123456";
                $baseDatos = "todo_app";
                $puerto = "27017";
    
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
