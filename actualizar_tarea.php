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
        <h2>Actualizar tarea</h2>
        
        <form action="./procesos/actualizar_tarea.php" method="POST">
          <input type="hidden" name="id" value="<?php echo $tarea->_id; ?>">
          
          <div class="mb-3">
            <label for="titulo" class="form-label">Título de la tarea</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $tarea->titulo; ?>" required>
          </div>
          
          <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?php echo $tarea->descripcion; ?></textarea>
          </div>
          
          <div class="row">
            <div class="col-md-4 mb-3">
              <label for="fecha_limite" class="form-label">Fecha límite</label>
              <input type="date" class="form-control" id="fecha_limite" name="fecha_limite" value="<?php echo date('Y-m-d', strtotime($tarea->fecha_limite)); ?>" required>
            </div>
            
            <div class="col-md-4 mb-3">
              <label for="prioridad" class="form-label">Prioridad</label>
              <select class="form-select" id="prioridad" name="prioridad" required>
                <option value="baja" <?php echo $tarea->prioridad == 'baja' ? 'selected' : ''; ?>>Baja</option>
                <option value="media" <?php echo $tarea->prioridad == 'media' ? 'selected' : ''; ?>>Media</option>
                <option value="alta" <?php echo $tarea->prioridad == 'alta' ? 'selected' : ''; ?>>Alta</option>
              </select>
            </div>
            
            <div class="col-md-4 mb-3">
              <label for="estado" class="form-label">Estado</label>
              <select class="form-select" id="estado" name="estado" required>
                <option value="pendiente" <?php echo $tarea->estado == 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                <option value="en-proceso" <?php echo $tarea->estado == 'en-proceso' ? 'selected' : ''; ?>>En proceso</option>
                <option value="completada" <?php echo $tarea->estado == 'completada' ? 'selected' : ''; ?>>Completada</option>
              </select>
            </div>
          </div>
          
          <button type="submit" class="btn btn-warning">
            <i class="fas fa-save"></i> Actualizar tarea
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include "./scripts.php"; ?>