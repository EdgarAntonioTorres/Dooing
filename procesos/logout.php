<?php
session_start();
include "../clases/Conexion.php";
include "../clases/Auth.php";

$auth = new Auth();
$auth->cerrarSesion();

header("Location: ../index.php");
?>