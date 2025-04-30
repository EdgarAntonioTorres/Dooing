# Tests Unitarios para ToDoing

Este documento describe cómo ejecutar y mantener los tests unitarios para la aplicación ToDoing.

## Estructura de los Tests

Los tests unitarios están organizados en la carpeta `tests/` y siguen la misma estructura de namespaces que las clases que prueban:

- `ConexionTest.php` - Tests para la conexión a MongoDB
- `AuthTest.php` - Tests para autenticación de usuarios
- `TaskTest.php` - Tests para la gestión de tareas

## Requisitos para ejecutar los tests

- PHP 7.4 o superior
- Composer instalado
- Extensión MongoDB para PHP
- MongoDB 4.4 o superior (para los tests de integración)

## Ejecutar los tests localmente

Hay dos formas de ejecutar los tests:

### 1. Usando el script automatizado

```bash
# Dar permisos de ejecución si es necesario
chmod +x run_tests.sh

# Ejecutar el script
./run_tests.sh
```

### 2. Usando PHPUnit directamente

```bash
# Desde la raíz del proyecto
./vendor/bin/phpunit

# Para ejecutar un test específico
./vendor/bin/phpunit tests/AuthTest.php
```

## Integración con GitHub Actions

Este proyecto está configurado para ejecutar automáticamente los tests cada vez que se haga un push a las ramas `main` o `master`, o cuando se abra un Pull Request.

El archivo de configuración se encuentra en `.github/workflows/php-tests.yml`.

### Ver resultados en GitHub

1. Ve a la pestaña "Actions" en el repositorio de GitHub
2. Selecciona el workflow "PHP Tests"
3. Consulta los resultados de la ejecución

## Escribir nuevos tests

Para añadir nuevos tests:

1. Crea un nuevo archivo en la carpeta `tests/` con el nombre `{Clase}Test.php`
2. Extiende la clase `PHPUnit\Framework\TestCase` 
3. Crea métodos de test que sigan la convención `testNombreDelMetodo()`
4. Usa aserciones de PHPUnit para verificar resultados

Ejemplo:

```php
public function testAlgunaFuncionalidad() 
{
    $resultado = $objetoATestear->metodo();
    $this->assertEquals('valor esperado', $resultado);
}
```

## Mock Objects

Para tests que requieren acceso a la base de datos o servicios externos, usa mock objects:

```php
$mockObjeto = $this->createMock(ClaseARemplazar::class);
$mockObjeto->method('metodoARemplazar')->willReturn($valorEsperado);
```

Esto simula el comportamiento de las dependencias sin necesidad de conectarse a servicios reales.