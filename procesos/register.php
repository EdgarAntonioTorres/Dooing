<?php
session_start();
include "../clases/Conexion.php";
include "../clases/Auth.php";

use App\Auth;

$auth = new App\Auth();

// Verificar si se enviaron los campos necesarios
if (isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_confirm'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    
    // Validar campos
    if (empty($nombre) || empty($email) || empty($password) || empty($password_confirm)) {
        $_SESSION['registro_error'] = "Todos los campos son obligatorios";
        header("Location: ../register.php");
        exit();
    }
    
    // Verificar que las contraseñas coincidan
    if ($password !== $password_confirm) {
        $_SESSION['registro_error'] = "Las contraseñas no coinciden";
        header("Location: ../register.php");
        exit();
    }
    
    // Crear el usuario
    $datos = array(
        'nombre' => $nombre,
        'email' => $email,
        'password' => $password
    );
    
    $respuesta = $auth->registrarUsuario($datos);
    
    if ($respuesta['status'] == 'success') {
        // Mostrar mensaje de éxito y redirigir al login
        $_SESSION['registro_exitoso'] = "Cuenta creada con éxito. Inicia sesión con tus credenciales.";
        header("Location: ../login.php");
    } else {
        // Mostrar error
        $_SESSION['registro_error'] = $respuesta['mensaje'];
        header("Location: ../register.php");
    }
} else {
    $_SESSION['registro_error'] = "Datos no válidos";
    header("Location: ../register.php");
}
?>