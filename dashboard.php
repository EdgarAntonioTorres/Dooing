<?php 
session_start();

// Verificar si hay sesión activa
if (!isset($_SESSION['usuario_id'])) {
  header("Location: login.php");
  exit();
}

include "./clases/Conexion.php";
include "./clases/Task.php";

$task = new Task();

// Obtener filtros
$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'todas';
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'fecha_limite';

// Obtener tareas según los filtros
$tareas = $task->obtenerTareas($_SESSION['usuario_id'], $filtro, $orden);

// Mensaje del sistema
$mensaje = '';
if (isset($_SESSION['mensaje_tarea'])) {
  $mensaje = $task->mensajesTarea($_SESSION['mensaje_tarea']);
  unset($_SESSION['mensaje_tarea']);
}

include "./header.php";
?>

<div class="row mt-4">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2>Mis Tareas</h2>
          <a href="agregar_tarea.php" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Nueva tarea
          </a>
        </div>
        
        <!-- Filtros -->
        <div class="filtros">
          <form action="" method="GET" class="d-flex gap-3 w-100">
            <div class="flex-grow-1">
              <label for="filtro">Estado:</label>
              <select name="filtro" id="filtro" class="form-select" onchange="this.form.submit()">
                <option value="todas" <?php echo $filtro == 'todas' ? 'selected' : ''; ?>>Todas</option>
                <option value="pendiente" <?php echo $filtro == 'pendiente' ? 'selected' : ''; ?>>Pendientes</option>
                <option value="en-proceso" <?php echo $filtro == 'en-proceso' ? 'selected' : ''; ?>>En proceso</option>
                <option value="completada" <?php echo $filtro == 'completada' ? 'selected' : ''; ?>>Completadas</option>
              </select>
            </div>
            
            <div class="flex-grow-1">
              <label for="orden">Ordenar por:</label>
              <select name="orden" id="orden" class="form-select" onchange="this.form.submit()">
                <option value="fecha_limite" <?php echo $orden == 'fecha_limite' ? 'selected' : ''; ?>>Fecha límite</option>
                <option value="prioridad" <?php echo $orden == 'prioridad' ? 'selected' : ''; ?>>Prioridad</option>
                <option value="estado" <?php echo $orden == 'estado' ? 'selected' : ''; ?>>Estado</option>
              </select>
            </div>
          </form>
        </div>
        
        <!-- Lista de tareas -->
        <div class="tareas-lista">
          <?php 
          $hayTareas = false;
          foreach($tareas as $tarea): 
            $hayTareas = true;
            
            // Determinar clases según prioridad
            $prioridadClass = '';
            switch($tarea->prioridad) {
              case 'alta':
                $prioridadClass = 'prioridad-alta';
                break;
              case 'media':
                $prioridadClass = 'prioridad-media';
                break;
              case 'baja':
                $prioridadClass = 'prioridad-baja';
                break;
            }
            
            // Determinar clases según estado
            $estadoClass = '';
            switch($tarea->estado) {
              case 'pendiente':
                $estadoClass = 'estado-pendiente';
                break;
              case 'en-proceso':
                $estadoClass = 'estado-en-proceso';
                break;
              case 'completada':
                $estadoClass = 'estado-completada';
                break;
            }
          ?>
            <div class="tarea-item <?php echo $prioridadClass; ?>">
              <div class="tarea-info">
                <div class="tarea-titulo"><?php echo $tarea->titulo; ?></div>
                <div class="tarea-descripcion"><?php echo $tarea->descripcion; ?></div>
                <div class="tarea-meta">
                  <span><i class="fas fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($tarea->fecha_limite)); ?></span>
                  <span><i class="fas fa-flag"></i> Prioridad: <?php echo ucfirst($tarea->prioridad); ?></span>
                  <span><i class="fas fa-tasks"></i> Estado: <span class="<?php echo $estadoClass; ?>"><?php echo ucfirst($tarea->estado); ?></span></span>
                </div>
              </div>
              <div class="tarea-acciones">
                <form action="actualizar_tarea.php" method="POST" class="d-inline">
                  <input type="hidden" name="id" value="<?php echo $tarea->_id; ?>">
                  <button class="btn btn-sm btn-warning">
                    <i class="fas fa-edit">Actualizar</i>
                  </button>
                </form>
                <form action="eliminar_tarea.php" method="POST" class="d-inline">
                  <input type="hidden" name="id" value="<?php echo $tarea->_id; ?>">
                  <button class="btn btn-sm btn-danger">
                    <i class="fas fa-trash">Eliminar</i>
                  </button>
                </form>
              </div>
            </div>
          <?php endforeach; ?>
          
          <?php if(!$hayTareas): ?>
          <div class="empty-state">
            <i class="fas fa-tasks"></i>
            <h3>No hay tareas para mostrar</h3>
            <p>Agrega una nueva tarea para comenzar</p>
            <a href="agregar_tarea.php" class="btn btn-primary mt-3">
              <i class="fas fa-plus-circle"></i> Agregar tarea
            </a>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include "./scripts.php"; ?>
<script>
    let mensaje = <?php echo json_encode($mensaje); ?>;
    if (mensaje) {
      alert(mensaje);
    }
</script>
