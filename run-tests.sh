#!/bin/bash

# Script para ejecutar los tests de la aplicación

echo "Ejecutando pruebas unitarias con PHPUnit..."
echo "---------------------------------------------"

# Comprobar si PHPUnit está instalado
if [ ! -f "./vendor/bin/phpunit" ]; then
    echo "⚠️ PHPUnit no encontrado. Asegúrate de ejecutar 'composer install' primero."
    exit 1
fi

# Ejecutar los tests
./vendor/bin/phpunit --colors=always

# Verificar si los tests pasaron
if [ $? -eq 0 ]; then
    echo "✅ Todos los tests pasaron correctamente."
else
    echo "❌ Algunos tests fallaron. Revisa los errores arriba."
fi