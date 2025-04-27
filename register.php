<?php 
  session_start();
  
  // Si ya hay sesión iniciada, redirigir al dashboard
  if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit();
  }
  
  include "./header.php"; 
?>

<div class="row">
  <div class="col">
    <div class="card auth-card">
      <div class="card-body">
        <h2 class="text-center mb-4">Crear una cuenta</h2>
        
        <?php if(isset($_SESSION['registro_error'])): ?>
          <div class="alert alert-danger">
            <?php 
              echo $_SESSION['registro_error']; 
              unset($_SESSION['registro_error']);
            ?>
          </div>
        <?php endif; ?>
        
        <form action="./procesos/register.php" method="POST">
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre completo</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
          </div>
          
          <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          
          <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          
          <div class="mb-3">
            <label for="password_confirm" class="form-label">Confirmar contraseña</label>
            <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
          </div>
          
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Registrarse</button>
          </div>
        </form>
        
        <div class="text-center mt-3">
          <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include "./scripts.php"; ?>