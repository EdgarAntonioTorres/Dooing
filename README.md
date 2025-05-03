# ToDoing - Aplicación de Gestión de Tareas

ToDoing es una aplicación web de gestión de tareas desarrollada con PHP y MongoDB que permite a los usuarios organizar sus tareas diarias de forma eficiente.

## Características

- **Autenticación de Usuarios**
  - Registro de cuenta
  - Inicio de sesión
  - Cierre de sesión

- **Gestión de Tareas**
  - Crear tareas con título, descripción, fecha límite, prioridad y estado
  - Visualizar tareas en una lista organizada
  - Editar tareas existentes
  - Eliminar tareas

- **Organización**
  - Filtrar tareas por estado (pendiente, en proceso, completada)
  - Ordenar tareas por fecha límite, prioridad o estado

## Tecnologías Utilizadas

- **Backend**
  - PHP 8.0
  - MongoDB (base de datos NoSQL)

- **Frontend**
  - HTML5
  - CSS3 
  - Bootstrap 5
  - Font Awesome
  - JavaScript
  - SweetAlert para notificaciones

## Instalación

### Requisitos previos
- PHP 8.0 o superior
- MongoDB
- Composer

### Pasos de instalación

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/tu-usuario/todoing.git
   cd todoing
   ```

2. Instalar dependencias con Composer:
   ```bash
   composer install
   composer require mongodb/mongodb
   ```

3. Configurar MongoDB:
   - Crear una base de datos llamada `todo_app`
   - Crear un usuario para la base de datos:
   ```
   mongosh

   use todo_app

   db.createUser({
     user: "mongoadmin",
     pwd: "123456",
     roles: [{ role: "readWrite", db: "todo_app" }]
   })

   db.createCollection("usuarios")

   db.createCollection("tareas")
   ```

4. Configurar el entorno web:
   - Asegurarse de que el directorio del proyecto esté configurado en el servidor web (Apache, Nginx, etc.)
   - Verificar que las extensiones de PHP requeridas estén habilitadas: mongodb, mbstring, curl

5. Acceder a la aplicación:
   - Abrir un navegador y navegar a `http://localhost/todoing` (o la URL correspondiente según la configuración del servidor)

## Pruebas

Para ejecutar las pruebas unitarias:

```bash
./vendor/bin/phpunit
```

## Despliegue con GitHub Actions

La aplicación incluye un flujo de trabajo de GitHub Actions para ejecutar pruebas automáticamente en cada push o pull request a la rama principal.

## Estructura del Proyecto

```
├── clases/                # Clases PHP para la lógica de negocio
│   ├── Auth.php           # Autenticación de usuarios
│   ├── Conexion.php       # Conexión a MongoDB
│   └── Task.php           # Gestión de tareas
├── procesos/              # Controladores para procesar formularios
├── public/                # Recursos estáticos
│   ├── bootstrap5/        # Archivos de Bootstrap 5
│   ├── fontawesome/       # Archivos de Font Awesome
│   ├── css/               # Hojas de estilo personalizadas
│   └── js/                # Scripts de JavaScript
├── tests/                 # Pruebas unitarias
├── .github/workflows/     # Configuración de GitHub Actions
└── composer.json          # Configuración de dependencias
```
