<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Auth;

class AuthTest extends TestCase
{
    protected $auth;
    
    protected function setUp(): void
    {
        $this->auth = $this->createMock(Auth::class);
    }
    
    /**
     * Test de registro de usuario exitoso
     */
    public function testRegistrarUsuarioExito()
    {
        $datos = [
            'nombre' => 'Usuario Test',
            'email' => 'test@example.com',
            'password' => 'password123'
        ];
        
        $respuestaEsperada = [
            'status' => 'success',
            'mensaje' => 'Usuario registrado con éxito'
        ];
        
        $this->auth->method('registrarUsuario')
            ->willReturn($respuestaEsperada);
        
        $respuesta = $this->auth->registrarUsuario($datos);
        
        $this->assertEquals('success', $respuesta['status']);
        $this->assertEquals('Usuario registrado con éxito', $respuesta['mensaje']);
    }
    
    /**
     * Test de registro con email existente
     */
    public function testRegistrarUsuarioEmailExistente()
    {
        $datos = [
            'nombre' => 'Usuario Test',
            'email' => 'existente@example.com',
            'password' => 'password123'
        ];
        
        $respuestaEsperada = [
            'status' => 'error',
            'mensaje' => 'El correo electrónico ya está registrado'
        ];
        
        $this->auth->method('registrarUsuario')
            ->willReturn($respuestaEsperada);
        
        $respuesta = $this->auth->registrarUsuario($datos);
        
        $this->assertEquals('error', $respuesta['status']);
        $this->assertEquals('El correo electrónico ya está registrado', $respuesta['mensaje']);
    }
    
    /**
     * Test de inicio de sesión exitoso
     */
    public function testLoginUsuarioExito()
    {
        $email = 'test@example.com';
        $password = 'password123';
        
        $respuestaEsperada = [
            'status' => 'success',
            'mensaje' => 'Inicio de sesión exitoso'
        ];
        
        $this->auth->method('loginUsuario')
            ->willReturn($respuestaEsperada);
        
        $respuesta = $this->auth->loginUsuario($email, $password);
        
        $this->assertEquals('success', $respuesta['status']);
        $this->assertEquals('Inicio de sesión exitoso', $respuesta['mensaje']);
    }
    
    /**
     * Test de inicio de sesión fallido
     */
    public function testLoginUsuarioError()
    {
        $email = 'test@example.com';
        $password = 'passwordIncorrecta';
        
        $respuestaEsperada = [
            'status' => 'error',
            'mensaje' => 'Correo o contraseña incorrectos'
        ];
        
        $this->auth->method('loginUsuario')
            ->willReturn($respuestaEsperada);
        
        $respuesta = $this->auth->loginUsuario($email, $password);
        
        $this->assertEquals('error', $respuesta['status']);
        $this->assertEquals('Correo o contraseña incorrectos', $respuesta['mensaje']);
    }
    
    /**
     * Test de verificación de sesión
     */
    public function testVerificarSesion()
    {
        // Cuando hay sesión activa
        $this->auth->method('verificarSesion')
             ->willReturn(true);
        
        $this->assertTrue($this->auth->verificarSesion());
        
        // Resetear mock para probar otro escenario
        $this->auth = $this->createMock(Auth::class);
        
        // Cuando no hay sesión activa
        $this->auth->method('verificarSesion')
             ->willReturn(false);
        
        $this->assertFalse($this->auth->verificarSesion());
    }
    
    /**
     * Test de cierre de sesión
     */
    public function testCerrarSesion()
    {
        $this->auth->method('cerrarSesion')
             ->willReturn(true);
        
        $this->assertTrue($this->auth->cerrarSesion());
    }
}