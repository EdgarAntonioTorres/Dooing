<?php
session_start();
include "../clases/Conexion.php";
include "../clases/Auth.php";

use App\Auth;

$auth = new App\Auth();

// Verificar si se enviaron los campos necesarios
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Validar campos
    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = "Todos los campos son obligatorios";
        header("Location: ../login.php");
        exit();
    }
    
    // Intentar iniciar sesión
    $respuesta = $auth->loginUsuario($email, $password);
    
    if ($respuesta['status'] == 'success') {
        // Redirigir al dashboard
        header("Location: ../dashboard.php");
    } else {
        // Mostrar error
        $_SESSION['login_error'] = $respuesta['mensaje'];
        header("Location: ../login.php");
    }
} else {
    $_SESSION['login_error'] = "Datos no válidos";
    header("Location: ../login.php");
}
?>