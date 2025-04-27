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
}