<?php 
  session_start();
  
  // Verificar si hay sesión activa
  if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
  }
  
  include "./clases/Conexion.php";
  include "./clases/Task.php";
  
  // Obtener la tarea
  $task = new Task();
  $id = $_POST['id'];
  $tarea = $task->obtenerTarea($id);
  
  include "./header.php"; 
?>

<div class="row">
  <div class="col">
    <div class="card mt-4">
      <div class="card-body">
        <a href="dashboard.php" class="btn btn-outline-primary mb-3">
          <i class="fas fa-arrow-left"></i> Volver al dashboard
        </a>
        <h2>Eliminar tarea</h2>
        
        <div class="alert alert-danger mt-3">
          <p><strong>¿Estás seguro de que deseas eliminar esta tarea?</strong></p>
          <p>Esta acción no se puede deshacer.</p>
        </div>
        
        <div class="card mb-4">
          <div class="card-body">
            <h3><?php echo $tarea->titulo; ?></h3>
            <p><?php echo $tarea->descripcion; ?></p>
            <div class="tarea-meta">
              <span><i class="fas fa-calendar-alt"></i> Fecha límite: <?php echo date('d/m/Y', strtotime($tarea->fecha_limite)); ?></span>
              <span><i class="fas fa-flag"></i> Prioridad: <?php echo ucfirst($tarea->prioridad); ?></span>
              <span><i class="fas fa-tasks"></i> Estado: <?php echo ucfirst($tarea->estado); ?></span>
            </div>
          </div>
        </div>
        
        <form action="./procesos/eliminar_tarea.php" method="POST">
          <input type="hidden" name="id" value="<?php echo $tarea->_id; ?>">
          <div class="d-flex gap-2">
            <a href="dashboard.php" class="btn btn-secondary">
              <i class="fas fa-times"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-danger">
              <i class="fas fa-trash"></i> Eliminar permanentemente
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include "./scripts.php"; ?>