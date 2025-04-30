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

if (isset($_POST['titulo']) && isset($_POST['fecha_limite']) && isset($_POST['estado']) && isset($_POST['prioridad'])) {
    $datos = array(
        'titulo' => $_POST['titulo'],
        'descripcion' => $_POST['descripcion'],
        'fecha_limite' => $_POST['fecha_limite'],
        'prioridad' => $_POST['prioridad'],
        'estado' => $_POST['estado']
    );
    
    $respuesta = $task->crearTarea($datos);
    
    if ($respuesta->getInsertedId()) {
        $_SESSION['mensaje_tarea'] = 'insert';
        header("Location: ../dashboard.php");
    } else {
        echo "Error al insertar la tarea";
        print_r($respuesta);
    }
} else {
    echo "Faltan datos requeridos";
}
?>