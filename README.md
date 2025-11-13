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

- **Backend**: PHP 8.1, MongoDB (base de datos NoSQL)
- **Frontend**: HTML5, CSS3, Bootstrap 5, Font Awesome, JavaScript, SweetAlert

---

## 🚀 Instalación Rápida con Docker (Recomendado)

### Requisitos previos

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

### Método 1: Usando la imagen Docker pública (Más rápido)

1. **Crea un directorio para la aplicación:**
   ```bash
   mkdir todoing && cd todoing
   ```

2. **Descarga los archivos de configuración:**
   ```bash
   # Descargar docker-compose.yml
   curl -O https://raw.githubusercontent.com/EdgarAntonioTorres/Dooing/main/docker-compose.yml

   # Descargar init-mongo.js
   curl -O https://raw.githubusercontent.com/EdgarAntonioTorres/Dooing/main/init-mongo.js
   ```

   **O créalos manualmente:**

   **docker-compose.yml:**
   ```yaml
   version: '3.8'

   services:
     mongodb:
       image: mongo:5
       container_name: todoing_mongodb
       restart: always
       ports:
         - "27017:27017"
       environment:
         MONGO_INITDB_ROOT_USERNAME: mongoadmin
         MONGO_INITDB_ROOT_PASSWORD: "123456"
         MONGO_INITDB_DATABASE: todo_app
       volumes:
         - mongodb_data:/data/db
         - ./init-mongo.js:/docker-entrypoint-initdb.d/init-mongo.js:ro
       networks:
         - todoing_network

     web:
       image: tony127/todoing:latest
       container_name: todoing_php
       restart: always
       ports:
         - "8080:80"
       depends_on:
         - mongodb
       environment:
         MONGODB_HOST: mongodb
         MONGODB_PORT: "27017"
         MONGODB_USER: mongoadmin
         MONGODB_PASSWORD: "123456"
         MONGODB_DATABASE: todo_app
         MONGODB_AUTH_SOURCE: admin
       networks:
         - todoing_network

   volumes:
     mongodb_data:

   networks:
     todoing_network:
       driver: bridge
   ```

   **init-mongo.js:**
   ```javascript
   db = db.getSiblingDB('admin');
   print('Usuario root configurado correctamente');

   db = db.getSiblingDB('todo_app');
   db.createCollection('usuarios');
   db.createCollection('tareas');

   try {
       db.createUser({
           user: "mongoadmin",
           pwd: "123456",
           roles: [
               { role: "readWrite", db: "todo_app" },
               { role: "dbAdmin", db: "todo_app" }
           ]
       });
       print('Usuario mongoadmin creado en todo_app');
   } catch (e) {
       print('Usuario ya existe: ' + e);
   }

   db = db.getSiblingDB('todo_app_test');
   db.createCollection('usuarios');
   db.createCollection('tareas');

   try {
       db.createUser({
           user: "mongoadmin",
           pwd: "123456",
           roles: [
               { role: "readWrite", db: "todo_app_test" },
               { role: "dbAdmin", db: "todo_app_test" }
           ]
       });
       print('Usuario mongoadmin creado en todo_app_test');
   } catch (e) {
       print('Usuario ya existe en test: ' + e);
   }
   ```

3. **Inicia los contenedores:**
   ```bash
   docker-compose up -d
   ```

4. **Verifica que todo esté corriendo:**
   ```bash
   docker-compose ps
   ```

5. **Accede a la aplicación:**
   ```
   http://localhost:8080
   ```

### Método 2: Construyendo la imagen localmente

Si deseas modificar el código o construir tu propia versión:

1. **Clona el repositorio:**
   ```bash
   git clone https://github.com/EdgarAntonioTorres/Dooing.git
   cd Dooing
   ```

2. **Construye e inicia los contenedores:**
   ```bash
   docker-compose up -d --build
   ```

3. **Accede a la aplicación:**
   ```
   http://localhost:8080
   ```

### Comandos útiles de Docker

```bash
# Ver logs de la aplicación
docker-compose logs -f web

# Ver logs de MongoDB
docker-compose logs -f mongodb

# Detener los contenedores
docker-compose down

# Detener y eliminar volúmenes (borra todos los datos)
docker-compose down -v

# Reiniciar los servicios
docker-compose restart
```

---

## ⚙️ Personalización de la configuración

Puedes modificar las siguientes variables de entorno en el archivo `docker-compose.yml`:

| Variable | Descripción | Valor por defecto |
|----------|-------------|-------------------|
| `MONGODB_HOST` | Nombre del host de MongoDB | `mongodb` |
| `MONGODB_PORT` | Puerto de MongoDB | `27017` |
| `MONGODB_USER` | Usuario de MongoDB | `mongoadmin` |
| `MONGODB_PASSWORD` | Contraseña de MongoDB | `123456` |
| `MONGODB_DATABASE` | Nombre de la base de datos | `todo_app` |
| `MONGODB_AUTH_SOURCE` | Base de datos de autenticación | `admin` |

**⚠️ Importante para producción:** Cambia las contraseñas por defecto antes de desplegar en un entorno real.

### Persistencia de datos

Los datos de MongoDB se almacenan en un volumen Docker llamado `mongodb_data`, lo que garantiza que tus datos no se pierdan cuando los contenedores se detengan o reinicien.

---

## 🛠️ Instalación Manual (Sin Docker)

Si prefieres no usar Docker, sigue estos pasos:

### Requisitos previos

- PHP 8.1 o superior
- MongoDB 5.0 o superior
- Composer
- Servidor web (Apache/Nginx)

### Pasos de instalación

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/EdgarAntonioTorres/Dooing.git
   cd Dooing
   ```

2. **Instalar dependencias con Composer:**
   ```bash
   composer install
   ```

3. **Configurar MongoDB:**
   ```bash
   mongosh
   ```
   ```javascript
   use todo_app

   db.createUser({
     user: "mongoadmin",
     pwd: "123456",
     roles: [
       { role: "readWrite", db: "todo_app" },
       { role: "dbAdmin", db: "todo_app" }
     ]
   })

   db.createCollection('usuarios')
   db.createCollection('tareas')
   ```

4. **Configurar el servidor web:**
   - Asegurar que el directorio del proyecto esté en el DocumentRoot
   - Verificar que las extensiones de PHP estén habilitadas: `mongodb`, `mbstring`, `curl`
   - Habilitar `mod_rewrite` en Apache

5. **Configurar variables de entorno** (opcional):
   Crear un archivo `.env` o configurar en el servidor:
   ```
   MONGODB_HOST=localhost
   MONGODB_PORT=27017
   MONGODB_USER=mongoadmin
   MONGODB_PASSWORD=123456
   MONGODB_DATABASE=todo_app
   ```

6. **Acceder a la aplicación:**
   ```
   http://localhost/Dooing
   ```

---

## 🧪 Pruebas

Para ejecutar las pruebas unitarias:

```bash
./vendor/bin/phpunit
```

---

## 📁 Estructura del Proyecto

```
Dooing/
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
├── init-mongo.js          # Script de inicialización de MongoDB
└── composer.json          # Configuración de dependencias
```

---

## 🚀 Despliegue con GitHub Actions

La aplicación incluye un flujo de trabajo de GitHub Actions que ejecuta pruebas automáticamente en cada push o pull request a la rama principal.

---

## 🐛 Solución de Problemas

### Error: "Failed to resolve 'mongodb'"

Este error significa que la aplicación no puede conectarse a MongoDB. Soluciones:

1. **Verifica que ambos contenedores estén corriendo:**
   ```bash
   docker-compose ps
   ```

2. **Verifica que estén en la misma red:**
   ```bash
   docker network inspect todoing_network
   ```

3. **Reinicia los contenedores:**
   ```bash
   docker-compose restart
   ```

### La aplicación no carga en el navegador

1. **Verifica que el puerto 8080 no esté en uso:**
   ```bash
   netstat -ano | findstr :8080    # Windows
   lsof -i :8080                   # Linux/Mac
   ```

2. **Cambia el puerto en docker-compose.yml** si es necesario:
   ```yaml
   ports:
     - "9090:80"  # Usa el puerto 9090 en lugar de 8080
   ```

---

**⭐ Si este proyecto te fue útil, considera darle una estrella en GitHub!**