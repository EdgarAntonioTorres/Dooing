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
  - PHP 8.1
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

### Requisitos previos

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

### Método 1: Usando la imagen Docker pública

1. Crea un directorio para la aplicación:
   ```bash
   mkdir todoing && cd todoing
   ```

2. Descarga los archivos necesarios:
   ```bash
   # Descargar docker-compose.yml
   curl -O https://raw.githubusercontent.com/EdgarAntonioTorres/Dooing/main/docker-compose.yml

   # Descargar init-mongo.js
   curl -O https://raw.githubusercontent.com/EdgarAntonioTorres/Dooing/main/init-mongo.js
   ```

O crea los archivos manualmente:
docker-compose.yml:

```yaml
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
=======
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

init-mongo.js:

```javascript
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

db.createUser({
  user: "mongoadmin",
  pwd: "123456",
  roles: [{ role: "readWrite", db: "todo_app_test" }]
});
```

3. Inicia los contenedores

```bash
docker-compose up -d
```

4. Accede a la aplicación en tu navegador:
```
http://localhost:8080
```

## Método 2: Construyendo la imagen localmente

1. Clona este repositorio:

```bash
git clone https://github.com/EdgarAntonioTorres/Dooing.git
cd todoing
```

2. Construye e inicia los contenedores:

```bash
docker-compose up -d --build
```

3. Accede a la aplicación en tu navegador:
```
http://localhost:8080
```

### Personalización de la configuración
Puedes modificar las siguientes variables de entorno en el archivo docker-compose.yml para personalizar la configuración:

- MONGODB_HOST: El nombre del host de MongoDB (por defecto: mongodb)
- MONGODB_PORT: El puerto de MongoDB (por defecto: 27017)
- MONGODB_USER: El nombre de usuario de MongoDB (por defecto: mongoadmin)
- MONGODB_PASSWORD: La contraseña de MongoDB (por defecto: 123456)
- MONGODB_DATABASE: El nombre de la base de datos (por defecto: todo_app)

### Persistencia de datos
Los datos de MongoDB se almacenan en un volumen Docker llamado mongodb_data, lo que garantiza que tus datos no se pierdan cuando los contenedores se detengan o reinicien.

## Instalación manual

Si prefieres no usar Docker, puedes seguir estos pasos para instalar la aplicación manualmente:

### Requisitos previos

- PHP 8.1 o superior
- MongoDB y MongoShell
- Composer

### Pasos de instalación

1. Clonar el repositorio:

```bash
git clone https://github.com/EdgarAntonioTorres/Dooing.git
cd todoing
```

2. Instalar dependencias con Composer:

```bash
composer install
```

3. Configurar MongoDB:

- Crear una base de datos llamada todo_app

- Crear un usuario para la base de datos:

  ```
  mongosh

  use todo_app

  db.createUser({
    user: "mongoadmin",
    pwd: "123456",
    roles: [{ role: "readWrite", db: "todo_app" }]
  })
  ```

4. Configurar el entorno web:


- Asegurarse de que el directorio del proyecto esté configurado en el servidor web (Apache, Nginx, etc.)
Verificar que las extensiones de PHP requeridas estén habilitadas: mongodb, mbstring, curl


- Acceder a la aplicación: Abrir un navegador y navegar a http://localhost/todoing (o la URL correspondiente según la configuración del servidor)

## Pruebas

Para ejecutar las pruebas unitarias:
```
./vendor/bin/phpunit
```

## Despliegue con GitHub Actions

La aplicación incluye un flujo de trabajo de GitHub Actions para ejecutar pruebas automáticamente en cada push o pull request a la rama principal.

## Estructura del proyecto

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
├── docker-compose.yml     # Configuración de Docker Compose
├── Dockerfile             # Definición de la imagen Docker
└── composer.json          # Configuración de dependencias
```

Este README proporciona instrucciones claras para que los usuarios puedan utilizar tu aplicación ToDoing con Docker, ya sea descargando la imagen pública o construyéndola localmente. También mantiene la información sobre la instalación manual y otras secciones relevantes del README original.
=======