<?php
namespace App;

use App\Conexion;

class Auth {
    public function registrarUsuario($datos) {
        try {
            // Verificar si el usuario ya existe
            $conexion = Conexion::conectar();
            $usuarios = $conexion->usuarios;
            
            $usuarioExistente = $usuarios->findOne(['email' => $datos['email']]);
            if ($usuarioExistente) {
                return [
                    'status' => 'error',
                    'mensaje' => 'El correo electrónico ya está registrado'
                ];
            }
            
            // Encriptar contraseña
            $datos['password'] = password_hash($datos['password'], PASSWORD_DEFAULT);
            $datos['fecha_registro'] = date('Y-m-d H:i:s');
            
            $respuesta = $usuarios->insertOne($datos);
            if ($respuesta->getInsertedId()) {
                return [
                    'status' => 'success',
                    'mensaje' => 'Usuario registrado con éxito'
                ];
            } else {
                return [
                    'status' => 'error',
                    'mensaje' => 'Error al registrar el usuario'
                ];
            }
        } catch (\Throwable $th) {
            return [
                'status' => 'error',
                'mensaje' => $th->getMessage()
            ];
        }
    }
    
    public function loginUsuario($email, $password) {
        try {
            $conexion = Conexion::conectar();
            $usuarios = $conexion->usuarios;
            
            $usuario = $usuarios->findOne(['email' => $email]);
            
            if ($usuario && password_verify($password, $usuario->password)) {
                // Iniciar sesión
                $_SESSION['usuario_id'] = $usuario->_id;
                $_SESSION['nombre'] = $usuario->nombre;
                $_SESSION['email'] = $usuario->email;
                
                return [
                    'status' => 'success',
                    'mensaje' => 'Inicio de sesión exitoso'
                ];
            } else {
                return [
                    'status' => 'error',
                    'mensaje' => 'Correo o contraseña incorrectos'
                ];
            }
        } catch (\Throwable $th) {
            return [
                'status' => 'error',
                'mensaje' => $th->getMessage()
            ];
        }
    }
    
    public function verificarSesion() {
        if (isset($_SESSION['usuario_id'])) {
            return true;
        }
        return false;
    }
    
    public function cerrarSesion() {
        session_unset();
        session_destroy();
        return true;
    }
}