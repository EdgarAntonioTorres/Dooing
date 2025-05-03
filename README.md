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

## Instalación con Docker (Recomendado)

La forma más sencilla de ejecutar esta aplicación es usando Docker. Sigue estos pasos:

1. Asegúrate de tener instalados [Docker](https://docs.docker.com/get-docker/) y [Docker Compose](https://docs.docker.com/compose/install/).

2. Clona este repositorio:
   ```bash
   git clone https://github.com/tu-usuario/todoing.git
   cd todoing
  ```
3. Inicia los contenedores usando Docker Compose:
  ```
  docker-compose up -d
  ```
4. Accede a la aplicación en tu navegador:
  ```
  http://localhost:8080
  ```
## Personalización de la configuración

Puedes modificar la configuración en el archivo docker-compose.yml. Por ejemplo, para cambiar las credenciales de MongoDB:
  ```yaml
  mongodb:
  environment:
    - MONGO_INITDB_ROOT_USERNAME=tu_usuario
    - MONGO_INITDB_ROOT_PASSWORD=tu_contraseña
  ```

## Instalación manual

## Requisitos previos

- PHP 8.0 o superior
- MongoDB y MongoShell
- Composer

## Pasos de instalación

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
- Crear una base de datos llamada todo_app
- Crear un usuario para la base de datos:
  ```
  mongosh

  use todo_app

  db.usuarios.insertOne({
    nombre: "Nombre del Usuario",
    email: "usuario@example.com",
    password: "contraseña123"
  });

  db.createUser({
    user: "mongoadmin",
    pwd: "123456",
    roles: [{ role: "readWrite", db: "todo_app" }]
  })
  ```

4. Configurar el entorno web:
- Asegurarse de que el directorio del proyecto esté configurado en el servidor web (Apache, Nginx, etc.)
- Verificar que las extensiones de PHP requeridas estén habilitadas: mongodb, mbstring, curl

5. Acceder a la aplicación:
Abrir un navegador y navegar a http://localhost/todoing (o la URL correspondiente según la configuración del servidor)

## Imagen Docker

Esta aplicación está disponible como una imagen Docker en Docker Hub:
  ```bash
  docker pull tunombredeusuario/todoing:latest
  ```

## Uso de la imagen de Docker

Crea un archivo docker-compose.yml:
  ```yml
  version: '3.8'

  services:
    web:
      image: tunombredeusuario/todoing:latest
      ports:
        - "8080:80"
      depends_on:
        - mongodb
      environment:
        - MONGODB_HOST=mongodb
        - MONGODB_PORT=27017
        - MONGODB_USER=mongoadmin
        - MONGODB_PASSWORD=123456
        - MONGODB_DATABASE=todo_app

    mongodb:
      image: mongo:5
      environment:
        - MONGO_INITDB_ROOT_USERNAME=mongoadmin
        - MONGO_INITDB_ROOT_PASSWORD=123456
      ports:
        - "27017:27017"
      volumes:
        - mongodb_data:/data/db
        - ./init-mongo.js:/docker-entrypoint-initdb.d/init-mongo.js:ro

  volumes:
    mongodb_data:
  ```

2. Crea un archivo init-mongo.js:

  ```
  db = db.getSiblingDB('todo_app');

  db.createCollection('usuarios');
  db.createCollection('tareas');

  db.createUser({
    user: "mongoadmin",
    pwd: "123456",
    roles: [{ role: "readWrite", db: "todo_app" }]
  });

  // Base de datos para tests
  db = db.getSiblingDB('todo_app_test');
  db.createCollection('usuarios');
  db.createCollection('tareas');
  ```

3. Ejecuta los contenedores:
  ```
  docker-compose up -d
  ```

## Pruebas

Para ejecutar las pruebas unitarias:
  ```
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