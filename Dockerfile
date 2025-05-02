FROM php:7.4-apache

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    wget \
    git \
    unzip \
    libonig-dev

# Instalar extensión MongoDB para PHP - Versión 1.16.2 que es compatible con PHP 7.4
RUN pecl install mongodb-1.16.2 && docker-php-ext-enable mongodb

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configurar Apache
RUN a2enmod rewrite

# Copiar archivos de la aplicación
WORKDIR /var/www/html
COPY . .

# Eliminar composer.lock para forzar la instalación desde composer.json
RUN rm -f composer.lock

# Instalar dependencias con Composer
# Usamos --ignore-platform-req=ext-mongodb para evitar problemas de compatibilidad
RUN composer install --no-interaction --optimize-autoloader --no-dev --ignore-platform-req=ext-mongodb

# Establecer permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && mkdir -p logs \
    && chmod -R 777 logs

# Exposición del puerto
EXPOSE 80

# Comando de inicio
CMD ["apache2-foreground"]