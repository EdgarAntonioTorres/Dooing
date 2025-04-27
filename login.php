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
        <h2 class="text-center mb-4">Iniciar sesión</h2>
        
        <?php if(isset($_SESSION['login_error'])): ?>
          <div class="alert alert-danger">
            <?php 
              echo $_SESSION['login_error']; 
              unset($_SESSION['login_error']);
            ?>
          </div>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['registro_exitoso'])): ?>
          <div class="alert alert-success">
            <?php 
              echo $_SESSION['registro_exitoso']; 
              unset($_SESSION['registro_exitoso']);
            ?>
          </div>
        <?php endif; ?>
        
        <form action="./procesos/login.php" method="POST">
          <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          
          <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
          </div>
        </form>
        
        <div class="text-center mt-3">
          <p>¿No tienes una cuenta? <a href="register.php">Regístrate</a></p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include "./scripts.php"; ?>