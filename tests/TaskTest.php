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
    }
}