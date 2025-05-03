FROM php:8.1-apache

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    zip \
    unzip \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    iputils-ping \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensión MongoDB para PHP correctamente
RUN pecl install mongodb-1.13.0 && \
    echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/mongodb.ini && \
    docker-php-ext-enable mongodb

# Instalar extensiones PHP adicionales
RUN docker-php-ext-install mbstring pdo pdo_mysql zip exif pcntl

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite

# Configurar directorio de trabajo
WORKDIR /var/www/html

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar composer.json y composer.lock primero para aprovechar la caché de Docker
COPY composer.json composer.lock /var/www/html/

# Instalar dependencias
RUN composer install --no-interaction --no-scripts --ignore-platform-reqs

# Configurar Apache para permitir .htaccess
RUN echo '<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/htaccess.conf \
    && a2enconf htaccess

# Activar errores de PHP para depuración
RUN echo 'display_errors = On\n\
error_reporting = E_ALL' > /usr/local/etc/php/conf.d/error-reporting.ini

# Copiar el resto de la aplicación
COPY . /var/www/html/

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;

# Exponer puerto
EXPOSE 80

# Configurar variables de entorno por defecto
ENV MONGODB_HOST=mongodb
ENV MONGODB_PORT=27017
ENV MONGODB_USER=mongoadmin
ENV MONGODB_PASSWORD=123456
ENV MONGODB_DATABASE=todo_app

# Directamente usar apache2-foreground para iniciar
CMD ["apache2-foreground"]