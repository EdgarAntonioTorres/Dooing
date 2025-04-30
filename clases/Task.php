<?php
namespace App;

use App\Conexion;

class Task extends Conexion {
    public function crearTarea($datos) {
        try {
            $conexion = parent::conectar();
            $tareas = $conexion->tareas;
            
            // Agregar el ID de usuario a la tarea
            $datos['usuario_id'] = new \MongoDB\BSON\ObjectId($_SESSION['usuario_id']);
            $datos['fecha_creacion'] = date('Y-m-d H:i:s');
            
            $respuesta = $tareas->insertOne($datos);
            return $respuesta;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    
    public function obtenerTareas($usuario_id, $filtro = null, $orden = 'fecha_limite') {
        try {
            $conexion = parent::conectar();
            $tareas = $conexion->tareas;
            
            $query = ['usuario_id' => new \MongoDB\BSON\ObjectId($usuario_id)];
            
            // Aplicar filtro por estado si existe
            if ($filtro && $filtro !== 'todas') {
                $query['estado'] = $filtro;
            }
            
            // Determinar el orden
            $ordenQuery = [];
            switch ($orden) {
                case 'fecha_limite':
                    $ordenQuery = ['fecha_limite' => 1]; // Ascendente por fecha
                    break;
                case 'prioridad':
                    $ordenQuery = ['prioridad' => -1]; // Descendente por prioridad
                    break;
                case 'estado':
                    $ordenQuery = ['estado' => 1]; // Ascendente por estado
                    break;
                default:
                    $ordenQuery = ['fecha_limite' => 1];
            }
            
            $datos = $tareas->find($query, ['sort' => $ordenQuery]);
            return $datos;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    
    public function obtenerTarea($id) {
        try {
            $conexion = parent::conectar();
            $tareas = $conexion->tareas;
            
            $datos = $tareas->findOne([
                '_id' => new \MongoDB\BSON\ObjectId($id),
                'usuario_id' => new \MongoDB\BSON\ObjectId($_SESSION['usuario_id'])
            ]);
            
            return $datos;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    
    public function actualizarTarea($id, $datos) {
        try {
            $conexion = parent::conectar();
            $tareas = $conexion->tareas;
            
            $respuesta = $tareas->updateOne(
                [
                    '_id' => new \MongoDB\BSON\ObjectId($id),
                    'usuario_id' => new \MongoDB\BSON\ObjectId($_SESSION['usuario_id'])
                ],
                ['$set' => $datos]
            );
            
            return $respuesta;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    
    public function eliminarTarea($id) {
        try {
            $conexion = parent::conectar();
            $tareas = $conexion->tareas;
            
            $respuesta = $tareas->deleteOne([
                '_id' => new \MongoDB\BSON\ObjectId($id),
                'usuario_id' => new \MongoDB\BSON\ObjectId($_SESSION['usuario_id'])
            ]);
            
            return $respuesta;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    
    public function mensajesTarea($mensaje) {
        $msg = '';
        
        if ($mensaje == 'insert') {
            $msg = 'swal("¡Genial!", "Tarea agregada con éxito", "success");';
        } else if ($mensaje == 'update') {
            $msg = 'swal("¡Excelente!", "Tarea actualizada con éxito", "info");';
        } else if ($mensaje == 'delete') {
            $msg = 'swal("¡Listo!", "Tarea eliminada con éxito", "warning");';
        }
        
        return $msg;
    }
}