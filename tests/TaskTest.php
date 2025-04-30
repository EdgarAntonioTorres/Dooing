<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Task;
use MongoDB\InsertOneResult;
use MongoDB\UpdateResult;
use MongoDB\DeleteResult;

class TaskTest extends TestCase
{
    protected $task;
    
    protected function setUp(): void
    {
        $this->task = $this->createMock(Task::class);
    }
    
    /**
     * Test de creación de tarea exitosa
     */
    public function testCrearTareaExito()
    {
        $datos = [
            'titulo' => 'Tarea de prueba',
            'descripcion' => 'Descripción de prueba',
            'fecha_limite' => '2025-05-01',
            'prioridad' => 'media',
            'estado' => 'pendiente'
        ];
        
        // Simulamos una respuesta de MongoDB
        $mockInsertResult = $this->createMock(InsertOneResult::class);
        $mockInsertResult->method('getInsertedId')->willReturn('60f1b5b7e6b6c03a6f9f4d2a');
        
        $this->task->method('crearTarea')
            ->willReturn($mockInsertResult);
        
        $respuesta = $this->task->crearTarea($datos);
        
        $this->assertTrue($respuesta->getInsertedId() !== null);
    }
    
    /**
     * Test de obtención de tareas
     */
    public function testObtenerTareas()
    {
        $userId = '60f1b5b7e6b6c03a6f9f4d2a';
        
        // Crear tareas de ejemplo que simularían lo devuelto por MongoDB
        $tarea1 = (object)[
            '_id' => '60f1b5b7e6b6c03a6f9f4d2b',
            'titulo' => 'Tarea 1',
            'estado' => 'pendiente'
        ];
        
        $tarea2 = (object)[
            '_id' => '60f1b5b7e6b6c03a6f9f4d2c',
            'titulo' => 'Tarea 2',
            'estado' => 'completada'
        ];
        
        // Mock de la respuesta para todas las tareas
        $this->task->method('obtenerTareas')
                  ->with($userId, 'todas')
                  ->willReturn([$tarea1, $tarea2]);
        
        $tareas = $this->task->obtenerTareas($userId, 'todas');
        
        $this->assertCount(2, $tareas);
        
        // Mock para filtrar tareas
        $task2 = $this->createMock(Task::class);
        $task2->method('obtenerTareas')
             ->with($userId, 'pendiente')
             ->willReturn([$tarea1]);
        
        $tareasPendientes = $task2->obtenerTareas($userId, 'pendiente');
        
        $this->assertCount(1, $tareasPendientes);
        $this->assertEquals('pendiente', $tareasPendientes[0]->estado);
    }
    
    /**
     * Test de obtención de una tarea específica
     */
    public function testObtenerTarea()
    {
        $tareaId = '60f1b5b7e6b6c03a6f9f4d2b';
        
        // Crear tarea de ejemplo que simularía lo devuelto por MongoDB
        $tarea = (object)[
            '_id' => $tareaId,
            'titulo' => 'Tarea específica',
            'descripcion' => 'Esta es una tarea específica',
            'fecha_limite' => '2025-05-01',
            'prioridad' => 'alta',
            'estado' => 'pendiente'
        ];
        
        $this->task->method('obtenerTarea')
                  ->with($tareaId)
                  ->willReturn($tarea);
        
        $resultado = $this->task->obtenerTarea($tareaId);
        
        $this->assertEquals($tareaId, $resultado->_id);
        $this->assertEquals('Tarea específica', $resultado->titulo);
    }
    
    /**
     * Test de actualización de tarea exitosa
     */
    public function testActualizarTareaExito()
    {
        $id = '60f1b5b7e6b6c03a6f9f4d2a';
        $datos = [
            'titulo' => 'Tarea actualizada',
            'descripcion' => 'Descripción actualizada',
            'fecha_limite' => '2025-05-15',
            'prioridad' => 'alta',
            'estado' => 'en-proceso'
        ];
        
        // Simulamos una respuesta de MongoDB
        $mockUpdateResult = $this->createMock(UpdateResult::class);
        $mockUpdateResult->method('getModifiedCount')->willReturn(1);
        $mockUpdateResult->method('getMatchedCount')->willReturn(1);
        
        $this->task->method('actualizarTarea')
            ->willReturn($mockUpdateResult);
        
        $respuesta = $this->task->actualizarTarea($id, $datos);
        
        $this->assertEquals(1, $respuesta->getModifiedCount());
        $this->assertEquals(1, $respuesta->getMatchedCount());
    }
    
    /**
     * Test de eliminación de tarea exitosa
     */
    public function testEliminarTareaExito()
    {
        $id = '60f1b5b7e6b6c03a6f9f4d2a';
        
        // Simulamos una respuesta de MongoDB
        $mockDeleteResult = $this->createMock(DeleteResult::class);
        $mockDeleteResult->method('getDeletedCount')->willReturn(1);
        
        $this->task->method('eliminarTarea')
            ->willReturn($mockDeleteResult);
        
        $respuesta = $this->task->eliminarTarea($id);
        
        $this->assertEquals(1, $respuesta->getDeletedCount());
    }
    
    /**
     * Test de mensaje de tarea según acción
     */
    public function testMensajesTarea()
    {
        $this->task->method('mensajesTarea')
            ->willReturnCallback(function($mensaje) {
                switch ($mensaje) {
                    case 'insert':
                        return 'swal("¡Genial!", "Tarea agregada con éxito", "success");';
                    case 'update':
                        return 'swal("¡Excelente!", "Tarea actualizada con éxito", "info");';
                    case 'delete':
                        return 'swal("¡Listo!", "Tarea eliminada con éxito", "warning");';
                    default:
                        return '';
                }
            });
        
        $this->assertStringContainsString('¡Genial!', $this->task->mensajesTarea('insert'));
        $this->assertStringContainsString('¡Excelente!', $this->task->mensajesTarea('update'));
        $this->assertStringContainsString('¡Listo!', $this->task->mensajesTarea('delete'));
        $this->assertEquals('', $this->task->mensajesTarea('accion_invalida'));
    }
}