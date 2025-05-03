#!/bin/bash
set -e

# Si el directorio vendor no existe, instalar dependencias
if [ ! -d "/var/www/html/vendor" ]; then
    echo "Instalando dependencias..."
    # Eliminar composer.lock si existe
    if [ -f "composer.lock" ]; then
        rm composer.lock
    fi

    # Instalar dependencias
    composer install --ignore-platform-req=ext-mongodb
fi

# Establecer permisos correctos
chown -R www-data:www-data /var/www/html

# Actualizar clase de conexión para usar variables de entorno
echo "<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    class Conexion {
        public function conectar() {
            try {
                \$servidor = getenv('MONGODB_HOST') ?: \"127.0.0.1\";
                \$usuario = getenv('MONGODB_USER') ?: \"mongoadmin\";
                \$password = getenv('MONGODB_PASSWORD') ?: \"123456\";
                \$baseDatos = getenv('MONGODB_DATABASE') ?: \"todo_app\";
                \$puerto = getenv('MONGODB_PORT') ?: \"27017\";
    
                \$cadenaConexion = \"mongodb://\" .
                                    \$usuario . \":\" .
                                    \$password . \"@\" .
                                    \$servidor . \":\" .
                                    \$puerto . \"/\" .
                                    \$baseDatos;
    
                \$cliente = new MongoDB\Client(\$cadenaConexion);
                return \$cliente->selectDatabase(\$baseDatos);
            } catch (\Throwable \$th) {
                return \$th->getMessage();
            }
        }
    }
?>" > /var/www/html/clases/Conexion.php

# Ejecutar comando original
exec "$@"