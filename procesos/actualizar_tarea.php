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

if (isset($_POST['id']) && isset($_POST['titulo']) && isset($_POST['fecha_limite'])) {
    $id = $_POST['id'];
    $datos = array(
        'titulo' => $_POST['titulo'],
        'descripcion' => $_POST['descripcion'],
        'fecha_limite' => $_POST['fecha_limite'],
        'prioridad' => $_POST['prioridad'],
        'estado' => $_POST['estado']
    );
    
    $respuesta = $task->actualizarTarea($id, $datos);
    
    if ($respuesta->getModifiedCount() > 0 || $respuesta->getMatchedCount() > 0) {
        $_SESSION['mensaje_tarea'] = 'update';
        header("Location: ../dashboard.php");
    } else {
        echo "Error al actualizar la tarea";
        print_r($respuesta);
    }
} else {
    echo "Faltan datos requeridos";
}
?> 