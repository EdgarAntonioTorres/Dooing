<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>📝 ToDoing | Organiza tus tareas</title>
  <link rel="stylesheet" href="./public/bootstrap5/bootstrap.min.css">
  <link rel="stylesheet" href="./public/fontawesome/css/all.css">
  <link rel="stylesheet" href="./public/css/estilo.css">
</head>
<body>
  <div class="main-content">
    <header class="main-header">
      <div class="container">
        <h1 class="logo">📝 ToDoing</h1>
        <nav class="nav-links">
          <?php if(isset($_SESSION['usuario_id'])): ?>
            <a href="dashboard.php"><i class="fas fa-home"></i> Inicio</a>
            <a href="agregar_tarea.php"><i class="fas fa-plus-circle"></i> Nueva Tarea</a>
            <span class="user-info">¡Hola, <?php echo $_SESSION['nombre']; ?>!</span>
            <a href="procesos/logout.php" class="logout-link"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
          <?php else: ?>
            <a href="index.php"><i class="fas fa-home"></i> Inicio</a>
            <a href="login.php"><i class="fas fa-sign-in-alt"></i> Iniciar sesión</a>
            <a href="register.php"><i class="fas fa-user-plus"></i> Registrarse</a>
          <?php endif; ?>
        </nav>
      </div>
    </header>
    
    <main class="container">