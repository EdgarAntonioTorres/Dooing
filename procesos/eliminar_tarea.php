<?php
session_start();

// Verificar si hay sesión activa
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

include "../clases/Conexion.php";
include "../clases/Task.php";

$task = new App\Task();


$task = new App\Task();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    $respuesta = $task->eliminarTarea($id);
    
    if ($respuesta->getDeletedCount() > 0) {
        $_SESSION['mensaje_tarea'] = 'delete';
        header("Location: ../dashboard.php");
    } else {
        echo "Error al eliminar la tarea";
        print_r($respuesta);
    }
} else {
    echo "ID de tarea no proporcionado";
}
?>