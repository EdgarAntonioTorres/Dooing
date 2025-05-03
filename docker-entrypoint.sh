#!/bin/bash
set -e

# Función para verificar la disponibilidad de MongoDB
check_mongo() {
    echo "********************************************"
    echo "Esperando a que MongoDB esté disponible..."
    echo "********************************************"
    
    MONGODB_HOST="${MONGODB_HOST:-mongodb}"
    MONGODB_PORT="${MONGODB_PORT:-27017}"
    MONGODB_USER="${MONGODB_USER:-mongoadmin}"
    MONGODB_PASSWORD="${MONGODB_PASSWORD:-123456}"
    MONGODB_DATABASE="${MONGODB_DATABASE:-todo_app}"
    
    echo "Usando configuración:"
    echo "- Host: $MONGODB_HOST"
    echo "- Puerto: $MONGODB_PORT"
    echo "- Usuario: $MONGODB_USER"
    echo "- Base de datos: $MONGODB_DATABASE"
    
    # Verificar que podemos hacer ping al host de MongoDB
    echo "Verificando conectividad a $MONGODB_HOST..."
    ping -c 3 $MONGODB_HOST || echo "No se puede hacer ping a $MONGODB_HOST, pero continuaremos intentando conectar..."
    
    # Intentar conectar a MongoDB
    max_attempts=30
    attempt=1
    
    until php -r "
        \$host = '$MONGODB_HOST';
        \$port = '$MONGODB_PORT';
        \$user = '$MONGODB_USER';
        \$pass = '$MONGODB_PASSWORD';
        \$db = '$MONGODB_DATABASE';
        
        echo \"Intento de conexión #{$attempt}/{$max_attempts} a MongoDB...\n\";
        
        try {
            \$uri = 'mongodb://'.\$user.':'.\$pass.'@'.\$host.':'.\$port;
            echo \"URI de conexión: {\$uri}\n\";
            
            require '/var/www/html/vendor/autoload.php';
            \$client = new MongoDB\Client(\$uri);
            \$database = \$client->selectDatabase(\$db);
            echo \"Conectado a MongoDB. Bases de datos disponibles:\n\";
            
            \$dbs = \$client->listDatabases();
            foreach (\$dbs as \$database) {
                echo \"- {\$database->getName()}\n\";
            }
            
            exit(0);
        } catch (Exception \$e) {
            echo \"Error de conexión: {\$e->getMessage()}\n\";
            exit(1);
        }
    "
    do
        echo "MongoDB no está disponible aún (intento $attempt de $max_attempts)..."
        
        if [ $attempt -eq $max_attempts ]; then
            echo "********************************************"
            echo "ADVERTENCIA: No se pudo conectar a MongoDB después de $max_attempts intentos"
            echo "Continuando de todos modos... La aplicación podría no funcionar correctamente."
            echo "********************************************"
            break
        fi
        
        attempt=$((attempt+1))
        sleep 2
    done
    
    echo "Preparación completa para iniciar la aplicación"
}

# Verificar configuración de PHP
echo "********************************************"
echo "Verificando configuración de PHP:"
echo "********************************************"
php -m | grep mongodb || echo "¡ADVERTENCIA! Extensión mongodb no está activada"
php -i | grep -i mongodb

# Verificar archivos de la aplicación
echo "********************************************"
echo "Verificando archivos de la aplicación:"
echo "********************************************"
ls -la /var/www/html

# Verificar permisos de directorios críticos
echo "********************************************"
echo "Ajustando permisos:"
echo "********************************************"
chown -R www-data:www-data /var/www/html
find /var/www/html -type d -exec chmod 755 {} \;
find /var/www/html -type f -exec chmod 644 {} \;

# Esperar a que MongoDB esté disponible
check_mongo

# Verificar configuración de Apache
echo "********************************************"
echo "Verificando configuración de Apache:"
echo "********************************************"
apache2ctl -t

# Habilitando errores PHP para depuración
echo "display_errors = On" >> /usr/local/etc/php/conf.d/error-reporting.ini
echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/error-reporting.ini

echo "********************************************"
echo "Iniciando Apache..."
echo "********************************************"

# Continuar con el comando especificado
exec "$@"