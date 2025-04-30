<?php
session_start();
include "../clases/Conexion.php";
include "../clases/Auth.php";

use App\Auth;

$auth = new App\Auth();

$auth->cerrarSesion();

header("Location: ../index.php");
?>