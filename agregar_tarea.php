<?php 
  session_start();
  
  // Verificar si hay sesión activa
  if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
  }
  
  include "./header.php"; 
?>

<div class="row">
  <div class="col">
    <div class="card mt-4">
      <div class="card-body">
        <a href="dashboard.php" class="btn btn-outline-primary mb-3">
          <i class="fas fa-arrow-left"></i> Volver al dashboard
        </a>
        <h2>Agregar nueva tarea</h2>
        
        <form action="./procesos/insertar_tarea.php" method="POST">
          <div class="mb-3">
            <label for="titulo" class="form-label">Título de la tarea</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
          </div>
          
          <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
          </div>
          
          <div class="row">
            <div class="col-md-4 mb-3">
              <label for="fecha_limite" class="form-label">Fecha límite</label>
              <input type="date" class="form-control" id="fecha_limite" name="fecha_limite" required>
            </div>
            
            <div class="col-md-4 mb-3">
              <label for="prioridad" class="form-label">Prioridad</label>
              <select class="form-select" id="prioridad" name="prioridad" required>
                <option value="baja">Baja</option>
                <option value="media" selected>Media</option>
                <option value="alta">Alta</option>
              </select>
            </div>
            
            <div class="col-md-4 mb-3">
              <label for="estado" class="form-label">Estado</label>
              <select class="form-select" id="estado" name="estado" required>
                <option value="pendiente" selected>Pendiente</option>
                <option value="en-proceso">En proceso</option>
                <option value="completada">Completada</option>
              </select>
            </div>
          </div>
          
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Guardar tarea
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include "./scripts.php"; ?>