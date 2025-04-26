<?php 
  session_start();
  include "./header.php"; 
?>

<section class="hero">
  <h2>Organiza tus tareas con ToDoing</h2>
  <p>Una aplicación intuitiva para gestionar tus tareas diarias de forma eficiente</p>
</section>

<div class="row">
  <div class="col-md-4">
    <div class="card">
      <div class="card-body text-center">
        <i class="fas fa-list-check fa-3x mb-3 text-primary"></i>
        <h3>Organización</h3>
        <p>Mantén todas tus tareas organizadas en un solo lugar.</p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body text-center">
        <i class="fas fa-filter fa-3x mb-3 text-primary"></i>
        <h3>Filtrado</h3>
        <p>Filtra tus tareas por estados o prioridades para enfocarte en lo importante.</p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body text-center">
        <i class="fas fa-check-double fa-3x mb-3 text-primary"></i>
        <h3>Seguimiento</h3>
        <p>Realiza un seguimiento de tu progreso y completa tus objetivos.</p>
      </div>
    </div>
  </div>
</div>

<div class="row mt-4">
  <div class="col">
    <div class="card">
      <div class="card-body text-center">
        <h3>¿Listo para empezar?</h3>
        <p>Regístrate para comenzar a gestionar tus tareas de manera eficiente.</p>
        <div class="d-flex justify-content-center gap-3 mt-3">
          <a href="register.php" class="btn btn-primary">Registrarse</a>
          <a href="login.php" class="btn btn-outline-primary">Iniciar sesión</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include "./footer.php"; ?>